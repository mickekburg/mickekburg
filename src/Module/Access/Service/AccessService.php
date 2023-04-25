<?php

namespace Module\Access\Service;

use Module\Access\DTO\AccessModuleDTO;
use Module\Access\Entity\AccessModule;
use Module\Access\Entity\AccessModuleRole;
use Module\Access\Mapper\AccessRoleToModuleDTOMapper;
use Module\User\Entity\User;

final class AccessService
{
    private static $instance;
    private static User $user;
    private static array $roles = [];

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
                    self::$roles[$menu_item->getModuleName()] = new AccessModuleDTO(
                        AccessModuleRole::ALLOW,
                        AccessModuleRole::ALLOW,
                        AccessModuleRole::ALLOW,
                        AccessModuleRole::ALLOW
                    );
                }
            }
        } else {
            /**
             * @var AccessModuleRole[]
             */
            $permissions = $db->getRepository(AccessModuleRole::class)->findBy(['user' => self::$user,]);
            foreach ($permissions as $permission_one) {
                self::$roles[$permission_one->getModule()->getModuleName()] = AccessRoleToModuleDTOMapper::map($permission_one);
            }

            $parents = array_reverse($db->getRepository(User::class)->getParents(self::$user->getId()));
            foreach ($parents as $parent) {
                $permissions = $db->getRepository(AccessModuleRole::class)->findBy(['user_group' => $parent,]);
                foreach ($permissions as $permission_one) {
                    $new_permission = AccessRoleToModuleDTOMapper::map($permission_one);
                    self::$roles[$permission_one->getModule()->getModuleName()] = AccessRoleToModuleDTOMapper::joinDTO(
                        $new_permission,
                        self::$roles[$permission_one->getModule()->getModuleName()] ?? null
                    );
                }
            }

            /**
             * @var AccessModule[]
             */
            $menu_items = $db->getRepository(AccessModule::class)->findAll();
            foreach ($menu_items as $menu_item) {
                if ($menu_item->getModuleName() && empty(self::$roles[$menu_item->getModuleName()])) {
                    self::$roles[$menu_item->getModuleName()] = new AccessModuleDTO(
                        AccessModuleRole::DENY,
                        AccessModuleRole::DENY,
                        AccessModuleRole::DENY,
                        AccessModuleRole::DENY
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
        $db = \Application::i()->getDbManager();
        $all_menu_items = $db->getRepository(AccessModule::class)->findBy([], ['parent' => 'ASC', 'sort' => 'ASC']);
        $result = [];
        foreach ($all_menu_items as $menu_item) {
            if (
                !$menu_item->getModuleName()
                || (
                    !empty(self::$roles[$menu_item->getModuleName()])
                    && self::$roles[$menu_item->getModuleName()]->{AccessModuleRole::ACTION_VIEW}
                )
            ) {
                $result[] = $menu_item;
            }
        }
        return $result;
    }

    public function hasPermission(\Core\Framework\ModuleInfo\ModuleInfo $module, string $action): bool
    {
        return !empty(self::$roles[$module->getModuleName()]) && self::$roles[$module->getModuleName()]->{$action};
    }

    public function getModulePermissions(\Core\Framework\ModuleInfo\ModuleInfo $module): ?AccessModuleDTO
    {
        if (!empty(self::$roles[$module->getModuleName()])) {
            return self::$roles[$module->getModuleName()];
        }
        return null;
    }

}