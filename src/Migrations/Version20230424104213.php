<?php

declare(strict_types=1);

namespace Migrations;

use Core\Framework\Helper\PasswordHelper;
use Core\Framework\Helper\StringHelper;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;


final class Version20230424104213 extends AbstractMigration
{

    public function getDescription(): string
    {
        return "Create default admin panel's users";
    }

    public function up(Schema $schema): void
    {
        $user_groups = [
            [
                'id' => 1,
                'name' => 'Администраторы',
                'can_delete' => false,
            ],
        ];

        foreach ($user_groups as $user_group) {
            $this->addSql('
                INSERT INTO `user_group`
                    (`id`, `name`, `can_delete`)
                VALUES 
                    (:id, :name, :can_delete)
            ', $user_group);
        }

        $salt1 = StringHelper::randomString();
        $salt2 = StringHelper::randomString();
        $users = [
            [
                'id' => 1,
                'parent_id' => 1,
                'login' => 'admin',
                'password_salt' => $salt1,
                'password' => PasswordHelper::generateSaltedPassword("12345", $salt1),
                'name' => 'Администратор',
                'can_delete' => false,
                'is_superadmin' => false,
            ],
            [
                'id' => 2,
                'parent_id' => 1,
                'login' => 'super',
                'password_salt' => $salt2,
                'password' => PasswordHelper::generateSaltedPassword("12345", $salt2),
                'name' => 'Суперадминистратор',
                'can_delete' => false,
                'is_superadmin' => true,
            ],
        ];

        foreach ($users as $user) {
            $this->addSql('
                INSERT INTO `user`
                    (`id`, `parent_id`, `login`, `password_salt`, `password`, `name`, `can_delete`, `is_superadmin`)
                VALUES 
                    (:id, :parent_id, :login, :password_salt, :password, :name, :can_delete, :is_superadmin)
            ', $user);
        }

    }

    public function down(Schema $schema): void
    {
        $this->addSql('TRUNCATE TABLE `user_group`');
        $this->addSql('TRUNCATE TABLE `user`');
    }
}
