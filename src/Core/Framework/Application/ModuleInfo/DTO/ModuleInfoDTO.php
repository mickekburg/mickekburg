<?php

namespace Core\Framework\Application\ModuleInfo\DTO;

class ModuleInfoDTO
{
    protected string $module_name;
    protected string $literal_name;
    protected string $default_order;
    /**
     * @var ModuleInfoTabDTO[]
     */
    protected array $tabs = [];
    /**
     * @var ModuleTableTdDTO[]
     */
    protected array $fields_tds = [];
    protected array $settings = [];
    protected string $actions = "";
    protected array $fields_group = [];


    /**
     * @return string
     */
    public function getModuleName(): string
    {
        return $this->module_name;
    }

    /**
     * @param string $module_name
     * @return ModuleInfoDTO
     */
    public function setModuleName(string $module_name): ModuleInfoDTO
    {
        $this->module_name = $module_name;
        return $this;
    }

    /**
     * @return string
     */
    public function getLiteralName(): string
    {
        return $this->literal_name;
    }

    /**
     * @param string $literal_name
     * @return ModuleInfoDTO
     */
    public function setLiteralName(string $literal_name): ModuleInfoDTO
    {
        $this->literal_name = $literal_name;
        return $this;
    }

    /**
     * @return string
     */
    public function getDefaultOrder(): string
    {
        return $this->default_order;
    }

    /**
     * @param string $default_order
     * @return ModuleInfoDTO
     */
    public function setDefaultOrder(string $default_order): ModuleInfoDTO
    {
        $this->default_order = $default_order;
        return $this;
    }

    /**
     * @return ModuleInfoTabDTO[]
     */
    public function getTabs(): array
    {
        return $this->tabs;
    }

    /**
     * @param array $tabs
     * @return ModuleInfoDTO
     */
    public function setTabs(array $tabs): ModuleInfoDTO
    {
        $this->tabs = $tabs;
        return $this;
    }



    /**
     * @return array
     */
    public function getSettings(): array
    {
        return $this->settings;
    }

    /**
     * @param array $settings
     * @return ModuleInfoDTO
     */
    public function setSettings(array $settings): ModuleInfoDTO
    {
        $this->settings = $settings;
        return $this;
    }

    /**
     * @return string
     */
    public function getActions(): string
    {
        return $this->actions;
    }

    /**
     * @param string $actions
     * @return $this
     */
    public function setActions(string $actions): ModuleInfoDTO
    {
        $this->actions = $actions;
        return $this;
    }

    /**
     * @return array
     */
    public function getFieldsGroup(): array
    {
        return $this->fields_group;
    }

    /**
     * @param array $fields_group
     * @return ModuleInfoDTO
     */
    public function setFieldsGroup(array $fields_group): ModuleInfoDTO
    {
        $this->fields_group = $fields_group;
        return $this;
    }

    /**
     * @return array
     */
    public function getFieldsTds(): array
    {
        return $this->fields_tds;
    }

    /**
     * @param array $fields_tds
     * @return ModuleInfoDTO
     */
    public function setFieldsTds(array $fields_tds): ModuleInfoDTO
    {
        $this->fields_tds = $fields_tds;
        return $this;
    }


}