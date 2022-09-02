<?php

namespace Module\Login\Config;

use Core\Framework\ModuleInfo\DTO\ModuleInfoDTO;
use Core\Framework\ModuleInfo\Factory\IConfigCreator;
use Core\Framework\ModuleInfo\Mapper\iModuleInfoDTOSerializer;

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