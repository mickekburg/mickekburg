<?php

namespace Core\Framework\Installer;

use Core\Common\Factory\AbstractConfigFactory;
use Core\Framework\Installer\DTO\InstallModuleDTO;
use Core\Framework\ModuleInfo\DTO\ModuleInfoDTO;
use Core\Framework\ModuleInfo\ModuleInfo;

class Installer
{
    private InstallModuleDTO $dto;
    public static array $default_install = ["User", "Access",];

    public function __construct(InstallModuleDTO $dto)
    {
        $this->dto = $dto;
    }

    public function install(): void
    {
        if (file_exists($this->dto->getConfigCreatorFile())) {
            $config_creator_name = $this->dto->getConfigCreatorName();
            $config_creator = new $config_creator_name();
            if ($config_creator instanceof AbstractConfigFactory) {
                file_put_contents($this->dto->getConfigFile(), $config_creator->createConfig());
            }
        }
    }

    public function getResult(): ModuleInfo
    {
        $module_info_serializer = \Application::i()->getFromDIContainer("module_info_serializer");
        $module_info_dto = $module_info_serializer->getSerializer()->deserialize(file_get_contents($this->dto->getConfigFile()), ModuleInfoDTO::class, 'xml');
        return new ModuleInfo($module_info_dto);
    }

}