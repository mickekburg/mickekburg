<?php

namespace Module\Access\Service;

use Module\Access\DTO\AccessModuleDTO;
use Module\Access\Entity\AccessModule;
use Module\Access\Entity\AccessModuleRool;
use Module\Access\Mapper\AccessRoolToModuleDTOMapper;
use Module\User\Entity\User;

final class AccessService
{
    private static $instance;
    private static User $user;
    private static array $rools = [];

    public static function i(): self
    {
        if (self::$instance === null) {
            self::$instance = new static();
            self::$user = \Application::i()->getUser();
            self::init();
        }
        return self::$instance;
    }

    private static function init(): void
    {
        $db = \Application::i()->getDbManager();

        if (self::$user->getIsSuperadmin()) {
            /**
             * @var AccessModule[]
             */
            $menu_items = $db->getRepository(AccessModule::class)->findAll();
            foreach ($menu_items as $menu_item) {
                if ($menu_item->getModuleName()) {
                    self::$rools[$menu_item->getModuleName()] = new AccessModuleDTO(
                        AccessModuleRool::ALLOW,
                        AccessModuleRool::ALLOW,
                        AccessModuleRool::ALLOW,
                        AccessModuleRool::ALLOW
                    );
                }
            }
        } else {
            /**
             * @var AccessModuleRool[]
             */
            $permissions = $db->getRepository(AccessModuleRool::class)->findBy(['user' => self::$user,]);
            foreach ($permissions as $permission_one) {
                self::$rools[$permission_one->getModule()->getModuleName()] = AccessRoolToModuleDTOMapper::map($permission_one);
            }

            $parents = array_reverse($db->getRepository(User::class)->getParents(self::$user->getId()));
            foreach ($parents as $parent) {
                $permissions = $db->getRepository(AccessModuleRool::class)->findBy(['user_group' => $parent,]);
                foreach ($permissions as $permission_one) {
                    $new_permission = AccessRoolToModuleDTOMapper::map($permission_one);
                    self::$rools[$permission_one->getModule()->getModuleName()] = AccessRoolToModuleDTOMapper::joinDTO(
                        $new_permission,
                        self::$rools[$permission_one->getModule()->getModuleName()] ?? null
                    );
                }
            }

            /**
             * @var AccessModule[]
             */
            $menu_items = $db->getRepository(AccessModule::class)->findAll();
            foreach ($menu_items as $menu_item) {
                if ($menu_item->getModuleName() && empty(self::$rools[$menu_item->getModuleName()])) {
                    self::$rools[$menu_item->getModuleName()] = new AccessModuleDTO(
                        AccessModuleRool::DENY,
                        AccessModuleRool::DENY,
                        AccessModuleRool::DENY,
                        AccessModuleRool::DENY
                    );
                }
            }
        }
    }

    /**
     * @param AccessModule[] $all_menu_items
     * @return array
     */
    public function getUserAvailableMenu(): array
    {
        print_r(self::$rools);
        $db = \Application::i()->getDbManager();
        $all_menu_items = $db->getRepository(AccessModule::class)->findBy([], ['parent' => 'ASC', 'sort' => 'ASC']);
        $result = [];
        foreach ($all_menu_items as $menu_item) {
            if (!$menu_item->getModuleName()) {
                $result[] = $menu_item;
            } else {

            }
        }
        return $result;
    }

}