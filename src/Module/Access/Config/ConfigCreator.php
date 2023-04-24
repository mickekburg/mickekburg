<?php

namespace Module\Access\Config;

use Config\DBConnectionFactory;
use Core\Common\Factory\AbstractConfigFactory;
use Core\Framework\ModuleInfo\DTO\ModuleInfoDTO;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Module\Access\Entity\AccessModule;
use Module\Access\Entity\AccessModuleRole;
use Module\User\Entity\UserGroup;

class ConfigCreator extends AbstractConfigFactory
{
    protected function createModuleInfo(): ModuleInfoDTO
    {
        return (new ModuleInfoDTO())
            ->setModuleName("Access")
            ->setLiteralName("Администрирования доступа");
    }

    protected function getModuleName(): string
    {
        return "Access";
    }

    protected function getModuleClasses(): array
    {
        return [AccessModule::class, AccessModuleRole::class];
    }

    protected function initEntityManagerPath(): array
    {
        return [
            APP_PATH . "src/Module/" . $this->getModuleName() . "/Entity",
            APP_PATH . "src/Module/" . $this->getModuleName() . "/User",
        ];
    }

    protected function getInitialEntity(): array
    {
        $entities = [];

        $translator = \Application::i()->getTranslator();

        $module_structure = new AccessModule();
        $module_structure->setId(AccessModule::MENU_STRUCTURE);
        $module_structure->setName($translator->trans('admin.modules.structure'));
        $module_structure->setModuleName("");
        $module_structure->setParent(null);
        $module_structure->setSort(AccessModule::MENU_STRUCTURE);
        $module_structure->setModuleIcon("fas fa-sitemap");
        $entities[] = $module_structure;

        $module_catalog = new AccessModule();
        $module_structure->setId(AccessModule::MENU_CATALOG);
        $module_catalog->setName($translator->trans('admin.modules.catalog'));
        $module_catalog->setModuleName("");
        $module_catalog->setParent(null);
        $module_catalog->setSort(AccessModule::MENU_CATALOG);
        $module_catalog->setModuleIcon("fas fa-list");
        $entities[] = $module_catalog;

        $module_user = new AccessModule();
        $module_structure->setId(AccessModule::MENU_USERS);
        $module_user->setName($translator->trans('admin.modules.users'));
        $module_user->setModuleName("User");
        $module_user->setParent(null);
        $module_user->setSort(AccessModule::MENU_USERS);
        $module_user->setModuleIcon("fas fa-users-cog");
        $entities[] = $module_user;

        $module_file = new AccessModule();
        $module_structure->setId(AccessModule::MENU_FILES);
        $module_file->setName($translator->trans('admin.modules.files'));
        $module_file->setModuleName("File");
        $module_file->setParent(null);
        $module_file->setSort(AccessModule::MENU_FILES);
        $module_file->setModuleIcon("fas fa-file-export");
        $entities[] = $module_file;

        $module_setting = new AccessModule();
        $module_structure->setId(AccessModule::MENU_SETTINGS);
        $module_setting->setName($translator->trans('admin.modules.settings'));
        $module_setting->setModuleName("Setting");
        $module_setting->setParent(null);
        $module_setting->setSort(AccessModule::MENU_SETTINGS);
        $module_setting->setModuleIcon("fas fa-cogs");
        $entities[] = $module_setting;

        $this->initEntityManager();
        $admin_group = $this->entity_manager->getRepository(UserGroup::class)->find(UserGroup::ADMIN_GROUP);
        foreach ([$module_user, $module_file, $module_setting] as $module) {
            $module_access = new AccessModuleRole();
            $module_access->setModule($module);
            $module_access->setUserGroup($admin_group);
            $module_access->setCanDelete(true);
            $module_access->setCanView(true);
            $module_access->setCanEdit(true);
            $module_access->setCanAdd(true);
            $entities[] = $module_access;
        }

        return $entities;
    }

}