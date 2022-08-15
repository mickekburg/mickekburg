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
    protected array $fieldsTds = [];
    protected array $settings = [];
    protected string $actions = "";
    protected array $fields_group = [];

    public function __construct(string $module_name, string $literal_name, string $default_order, array $tabs, array $fieldsTds, array $settings, string $actions, array $fields_group)
    {
        $this->module_name = $module_name;
        $this->literal_name = $literal_name;
        $this->default_order = $default_order;
        $this->tabs = $tabs;
        $this->fieldsTds = $fieldsTds;
        $this->settings = $settings;
        $this->actions = $actions;
        $this->fields_group = $fields_group;
    }

    /**
     * @return string
     */
    public function getModuleName(): string
    {
        return $this->module_name;
    }

    /**
     * @param string $module_name
     */
    public function setModuleName(string $module_name): void
    {
        $this->module_name = $module_name;
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
     */
    public function setLiteralName(string $literal_name): void
    {
        $this->literal_name = $literal_name;
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
     */
    public function setDefaultOrder(string $default_order): void
    {
        $this->default_order = $default_order;
    }

    /**
     * @return ModuleInfoTabDTO[]
     */
    public function getTabs(): array
    {
        return $this->tabs;
    }

    /**
     * @param ModuleInfoTabDTO[] $tabs
     */
    public function setTabs(array $tabs): void
    {
        $this->tabs = $tabs;
    }

    /**
     * @return array
     */
    public function getFieldsTds(): array
    {
        return $this->fieldsTds;
    }

    /**
     * @param array $fieldsTds
     */
    public function setFieldsTds(array $fieldsTds): void
    {
        $this->fieldsTds = $fieldsTds;
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
     */
    public function setSettings(array $settings): void
    {
        $this->settings = $settings;
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
     */
    public function setActions(string $actions): void
    {
        $this->actions = $actions;
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
     */
    public function setFieldsGroup(array $fields_group): void
    {
        $this->fields_group = $fields_group;
    }


}