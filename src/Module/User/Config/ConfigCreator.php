<?php

namespace Module\User\Config;

use Config\DBConnectionFactory;
use Core\Common\Command\InstallCommand;
use Core\Framework\ModuleInfo\DTO\ModuleFieldDTO;
use Core\Framework\ModuleInfo\DTO\ModuleInfoDTO;
use Core\Framework\ModuleInfo\DTO\ModuleInfoTabDTO;
use Core\Framework\ModuleInfo\DTO\ModuleTableActionDTO;
use Core\Framework\ModuleInfo\DTO\ModuleTableTdDTO;
use Core\Framework\ModuleInfo\Factory\IConfigCreator;
use Core\Framework\ModuleInfo\Mapper\iModuleInfoDTOSerializer;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Module\User\Entity\User;
use Module\User\Entity\UserGroup;

class ConfigCreator implements IConfigCreator
{

    public function createConfig(): string
    {
        $tabs = [];
        $fields = [];
        $fields[] = (new ModuleFieldDTO())
            ->setName("login")
            ->setTitle("Логин")
            ->setType(ModuleFieldDTO::TYPE_TEXT)
            ->setIsRequired(true)
            ->setIsActive(true);
        $fields[] = (new ModuleFieldDTO())
            ->setName("password")
            ->setTitle("Пароль")
            ->setType(ModuleFieldDTO::TYPE_PASSWORD)
            ->setIsRequired(true)
            ->setIsActive(true);
        $fields[] = (new ModuleFieldDTO())
            ->setName("pid")
            ->setTitle("Категории")
            ->setType(ModuleFieldDTO::TYPE_PID)
            ->setIsRequired(true)
            ->setIsActive(true);
        $fields[] = (new ModuleFieldDTO())
            ->setName("name")
            ->setTitle("Имя")
            ->setType(ModuleFieldDTO::TYPE_TEXT)
            ->setIsRequired(true);
        $fields[] = (new ModuleFieldDTO())
            ->setName("second_name")
            ->setTitle("Отчество")
            ->setType(ModuleFieldDTO::TYPE_TEXT);
        $fields[] = (new ModuleFieldDTO())
            ->setName("third_name")
            ->setTitle("Фамилия")
            ->setType(ModuleFieldDTO::TYPE_TEXT);
        $fields[] = (new ModuleFieldDTO())
            ->setName("phone")
            ->setTitle("Телефон")
            ->setType(ModuleFieldDTO::TYPE_TEXT);
        $fields[] = (new ModuleFieldDTO())
            ->setName("email")
            ->setTitle("Email")
            ->setType(ModuleFieldDTO::TYPE_EMAIL);
        $fields[] = (new ModuleFieldDTO())
            ->setName("date")
            ->setTitle("Дата и время регистрации")
            ->setType(ModuleFieldDTO::TYPE_DATETIME)
            ->setDefaultValue(ModuleFieldDTO::DATE_NOW);
        $tabs[] = (new ModuleInfoTabDTO())
            ->setName('Информация')
            ->setFields($fields);

        $fields = [];
        $fields[] = (new ModuleFieldDTO())
            ->setName("full_address")
            ->setTitle("Полный адрес")
            ->setType(ModuleFieldDTO::TYPE_TEXT);
        $fields[] = (new ModuleFieldDTO())
            ->setName("country")
            ->setTitle("Страна")
            ->setType(ModuleFieldDTO::TYPE_TEXT);
        $fields[] = (new ModuleFieldDTO())
            ->setName("index")
            ->setTitle("Индекс")
            ->setType(ModuleFieldDTO::TYPE_TEXT);
        $fields[] = (new ModuleFieldDTO())
            ->setName("region")
            ->setTitle("Область")
            ->setType(ModuleFieldDTO::TYPE_TEXT);
        $fields[] = (new ModuleFieldDTO())
            ->setName("city")
            ->setTitle("Город")
            ->setType(ModuleFieldDTO::TYPE_TEXT);
        $fields[] = (new ModuleFieldDTO())
            ->setName("street")
            ->setTitle("Улица")
            ->setType(ModuleFieldDTO::TYPE_TEXT);
        $fields[] = (new ModuleFieldDTO())
            ->setName("house")
            ->setTitle("Дом")
            ->setType(ModuleFieldDTO::TYPE_TEXT);
        $fields[] = (new ModuleFieldDTO())
            ->setName("building")
            ->setTitle("Корпус")
            ->setType(ModuleFieldDTO::TYPE_TEXT);
        $fields[] = (new ModuleFieldDTO())
            ->setName("entrance")
            ->setTitle("Подъезд")
            ->setType(ModuleFieldDTO::TYPE_TEXT);
        $fields[] = (new ModuleFieldDTO())
            ->setName("ground")
            ->setTitle("Этаж")
            ->setType(ModuleFieldDTO::TYPE_TEXT);
        $fields[] = (new ModuleFieldDTO())
            ->setName("flat")
            ->setTitle("Квартира")
            ->setType(ModuleFieldDTO::TYPE_TEXT);
        $tabs[] = (new ModuleInfoTabDTO())
            ->setName('Адрес')
            ->setFields($fields);

        $fields = [];
        $fields[] = (new ModuleFieldDTO())
            ->setName("file")
            ->setTitle("Изображение")
            ->setType(ModuleFieldDTO::TYPE_FILE)
            ->setValues(["png", "jpg", "jpeg", "svg", "gif",])
            ->setDefaultValue("200x150");
        $tabs[] = (new ModuleInfoTabDTO())
            ->setName('Изображения')
            ->setFields($fields);

        $tabs[] = (new ModuleInfoTabDTO())
            ->setName('Права')
            ->setAction('showRoolTab');

        $tds = [];
        $tds[] = (new ModuleTableTdDTO())
            ->setTitle('Логин')
            ->setMethod(ModuleTableTdDTO::METHOD_EDIT)
            ->setField('login')
            ->setIsFilter(true)
            ->setSort(true);
        $tds[] = (new ModuleTableTdDTO())
            ->setTitle('Имя')
            ->setMethod(ModuleTableTdDTO::METHOD_TEXT)
            ->setField('name')
            ->setIsFilter(true)
            ->setSort(true);
        $tds[] = (new ModuleTableTdDTO())
            ->setTitle('Телефон')
            ->setMethod(ModuleTableTdDTO::METHOD_TEXT)
            ->setField('phone')
            ->setIsFilter(true)
            ->setSort(true);

        $tabs2 = [];
        $fields = [];
        $fields[] = (new ModuleFieldDTO())
            ->setName("name")
            ->setTitle("Наименование")
            ->setType(ModuleFieldDTO::TYPE_TEXT)
            ->setIsRequired(true)
            ->setIsActive(true);
        $fields[] = (new ModuleFieldDTO())
            ->setName("pid")
            ->setTitle("Категория")
            ->setType(ModuleFieldDTO::TYPE_PID);
        $tabs2[] = (new ModuleInfoTabDTO())
            ->setName('Информация')
            ->setFields($fields);

        $settings = [];

        $actions = [];
        $actions[] = (new ModuleTableActionDTO())
            ->setFunction('editRow')
            ->setTitle('Редактировать');
        $actions[] = (new ModuleTableActionDTO())
            ->setFunction('deleteRow')
            ->setTitle('Удалить');

        $module = (new ModuleInfoDTO())
            ->setTabs($tabs)
            ->setFieldsTds($tds)
            ->setTabsGroup($tabs2)
            ->setSettings($settings)
            ->setActions($actions)
            ->setModuleName("User")
            ->setLiteralName("Пользователи")
            ->setDefaultOrder("id desc")
            ->setIsMultipids(false)
            ->setOnPage(20)
            ->setIsGroup(true);

        /**
         * @var iModuleInfoDTOSerializer
         */
        $serializer = \Application::i()->getFromDIContainer("module_info_serializer");

        $root_user_group = new UserGroup();
        $root_user_group->setName("Все пользователи");
        $root_user_group->setCanDelete(false);

        $default_user_group = new UserGroup();
        $default_user_group->setName("Администраторы");
        $default_user_group->setCanDelete(false);
        $default_user_group->setParent($root_user_group);

        $default_admin = new User();
        $default_admin->setLogin("admin");
        $default_admin->setName("Администратор");
        $default_admin->setCanDelete(false);
        $default_admin->setParent($default_user_group);
        $default_admin->setPassword("12345");

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
        $entity_manager = EntityManager::create($connection, $db_config);
        $tool = new \Doctrine\ORM\Tools\SchemaTool($entity_manager);
        $classes = array(
            $entity_manager->getClassMetadata(User::class),
            $entity_manager->getClassMetadata(UserGroup::class)
        );
        try {
            $tool->createSchema($classes);
        } catch (\Exception $ex) {
            $tool->dropSchema($classes);
            $tool->createSchema($classes);
        }

        (new InstallCommand($entity_manager))->setFillValues([$root_user_group, $default_user_group, $default_admin])->execute();

        return $serializer->getSerializer()->serialize($module, 'xml', ['xml_format_output' => true,]);
    }
}