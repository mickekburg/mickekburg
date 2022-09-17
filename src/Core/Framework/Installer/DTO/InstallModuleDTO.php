<?php

namespace Core\Framework\Installer\DTO;

class InstallModuleDTO
{
    private string $config_file;
    private string $config_creator_file;
    private string $config_creator_name;
    private string $module_name;

    public function __construct(string $config_file, string $config_creator_file, string $config_creator_name, string $module_name)
    {
        $this->config_file = $config_file;
        $this->config_creator_file = $config_creator_file;
        $this->config_creator_name = $config_creator_name;
        $this->module_name = $module_name;
    }

    /**
     * @return string
     */
    public function getConfigFile(): string
    {
        return $this->config_file;
    }

    /**
     * @return string
     */
    public function getConfigCreatorFile(): string
    {
        return $this->config_creator_file;
    }

    /**
     * @return string
     */
    public function getConfigCreatorName(): string
    {
        return $this->config_creator_name;
    }

    /**
     * @return string
     */
    public function getModuleName(): string
    {
        return $this->module_name;
    }
}