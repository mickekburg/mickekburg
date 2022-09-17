<?php

namespace Module\Main\Config;

use Core\Common\Factory\AbstractConfigFactory;
use Core\Framework\ModuleInfo\DTO\ModuleInfoDTO;

class ConfigCreator extends AbstractConfigFactory
{
    protected function createModuleInfo(): ModuleInfoDTO
    {
        return (new ModuleInfoDTO())
            ->setModuleName("Main")
            ->setLiteralName("Система администрирования");
    }

    protected function getModuleName(): string
    {
        return "Main";
    }

    protected function getModuleClasses(): array
    {
        return [];
    }

    protected function getInitialEntity(): array
    {
        return [];
    }
}