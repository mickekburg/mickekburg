<?php

namespace Module\Login\Config;

use Core\Common\Factory\AbstractConfigFactory;
use Core\Framework\ModuleInfo\DTO\ModuleInfoDTO;

class ConfigCreator extends AbstractConfigFactory
{
    protected function createModuleInfo(): ModuleInfoDTO
    {
        return (new ModuleInfoDTO())
            ->setModuleName("Login")
            ->setLiteralName("Авторизация");
    }

    protected function getModuleName(): string
    {
        return "Login";
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