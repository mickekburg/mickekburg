<?php

namespace Core\Common\Factory;

use Config\DBConnectionFactory;
use Core\Common\Command\InstallCommand;
use Core\Common\Dispatcher;
use Core\Framework\ModuleInfo\DTO\ModuleInfoDTO;
use Core\Framework\ModuleInfo\Mapper\iModuleInfoDTOSerializer;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

abstract class AbstractConfigFactory
{
    abstract protected function createModuleInfo(): ModuleInfoDTO;

    abstract protected function getModuleName(): string;

    abstract protected function getModuleClasses(): array;

    abstract protected function getInitialEntity(): array;

    public function createConfig(): string
    {
        $module = $this->createModuleInfo();

        /**
         * @var iModuleInfoDTOSerializer
         */
        try {
            $serializer = \Application::i()->getFromDIContainer("module_info_serializer");
        } catch (\Exception $e) {
            exit('module_info_serializer was not find in DI');
        }

        if($this->getModuleName()){
            $connection = DBConnectionFactory::getDbConfig();
            $db_config = ORMSetup::createAttributeMetadataConfiguration(
                [
                    APP_PATH . "src/Module/" . $this->getModuleName() . "/Entity",
                ],
                ENVIRONMENT == 'development',
                null,
                null,
                false
            );
            $entity_manager = EntityManager::create($connection, $db_config);
            $tool = new \Doctrine\ORM\Tools\SchemaTool($entity_manager);

            if (!empty($this->getModuleClasses())) {
                $classes = array_map([$entity_manager, 'getClassMetadata'], $this->getModuleClasses());
                try {
                    $tool->createSchema($classes);
                } catch (\Exception $ex) {
                    $tool->dropSchema($classes);
                    $tool->createSchema($classes);
                }
            }

            $install_command = Dispatcher::getInstallCommand($this->getModuleName());
            $install_command->setEntityManager($entity_manager);
            $install_command->setFillValues($this->getInitialEntity())->execute();
        }

        return $serializer->getSerializer()->serialize($module, 'xml', ['xml_format_output' => true,]);
    }
}