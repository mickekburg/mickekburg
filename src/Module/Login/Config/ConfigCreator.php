<?php

namespace Module\Login\Config;

use Core\Framework\Application\ModuleInfo\DTO\ModuleFieldDTO;
use Core\Framework\Application\ModuleInfo\DTO\ModuleInfoDTO;
use Core\Framework\Application\ModuleInfo\DTO\ModuleInfoTabDTO;
use Core\Framework\Application\ModuleInfo\DTO\ModuleSettingsDTO;
use Core\Framework\Application\ModuleInfo\DTO\ModuleTableActionDTO;
use Core\Framework\Application\ModuleInfo\DTO\ModuleTableTdDTO;
use Core\Framework\Application\ModuleInfo\Factory\IConfigCreator;
use Core\Framework\Application\ModuleInfo\Mapper\iModuleInfoDTOSerializer;

class ConfigCreator implements IConfigCreator
{

    public function createConfig(): string
    {
        $module = (new ModuleInfoDTO())
            ->setModuleName("Login")
            ->setLiteralName("Авторизация");

        /**
         * @var iModuleInfoDTOSerializer
         */
        $serializer = \Application::i()->getFromDIContainer("module_info_serializer");

        return $serializer->getSerializer()->serialize($module, 'xml', ['xml_format_output' => true,]);
    }
}