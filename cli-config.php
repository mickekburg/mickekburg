<?php

// php src/Cli/doctrine.php orm:schema-tool:create
// vendor/bin/doctrine-migrations migrations:migrate

use Config\DBConnectionFactory;
use Doctrine\Migrations\Configuration\EntityManager\ExistingEntityManager;
use Doctrine\Migrations\Configuration\Migration\PhpFile;
use Doctrine\Migrations\DependencyFactory;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

require 'vendor/autoload.php';
require __DIR__ . '/src/Config/Config.php';

$connection = DBConnectionFactory::getDbConfig();
$db_config = ORMSetup::createAttributeMetadataConfiguration(
    [
        APP_PATH . "src/Module/User/Entity",
    ],
    ENVIRONMENT == 'development',
    null,
    null,
    false
);
$entityManager = new EntityManager($connection, $db_config);

$migration_config = new PhpFile(__DIR__ . '/src/Cli/migrations.php');

return DependencyFactory::fromEntityManager($migration_config, new ExistingEntityManager($entityManager));