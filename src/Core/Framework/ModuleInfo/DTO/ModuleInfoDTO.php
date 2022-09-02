<?php

namespace Core\Framework\ModuleInfo\DTO;

class ModuleInfoDTO
{
    protected string $module_name;
    protected string $literal_name;
    protected string $default_order;
    protected bool $is_group = false;
    protected int $on_page = 10;
    protected bool $is_multipids = false;

    /**
     * @var ModuleInfoTabDTO[]
     */
    protected array $tabs = [];
    /**
     * @var ModuleTableTdDTO[]
     */
    protected array $fields_tds = [];
    /**
     * @var ModuleSettingsDTO[]
     */
    protected array $settings = [];
    /**
     * @var ModuleTableActionDTO[]
     */
    protected array $actions = [];
    /**
     * @var ModuleInfoTabDTO[]
     */
    protected array $tabs_group = [];


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
     * @return array
     */
    public function getActions(): array
    {
        return $this->actions;
    }

    /**
     * @param array $actions
     * @return $this
     */
    public function setActions(array $actions): ModuleInfoDTO
    {
        $this->actions = $actions;
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

    /**
     * @return ModuleInfoTabDTO[]
     */
    public function getTabsGroup(): array
    {
        return $this->tabs_group;
    }

    /**
     * @param ModuleInfoTabDTO[] $tabs_group
     * @return ModuleInfoDTO
     */
    public function setTabsGroup(array $tabs_group): ModuleInfoDTO
    {
        $this->tabs_group = $tabs_group;
        return $this;
    }

    /**
     * @return bool
     */
    public function getIsGroup(): bool
    {
        return $this->is_group;
    }

    /**
     * @param bool $is_group
     * @return ModuleInfoDTO
     */
    public function setIsGroup(bool $is_group): ModuleInfoDTO
    {
        $this->is_group = $is_group;
        return $this;
    }

    /**
     * @return int
     */
    public function getOnPage(): int
    {
        return $this->on_page;
    }

    /**
     * @param int $on_page
     * @return $this
     */
    public function setOnPage(int $on_page): self
    {
        $this->on_page = $on_page;
        return $this;
    }

    /**
     * @return bool
     */
    public function getIsMultipids(): bool
    {
        return $this->is_multipids;
    }

    /**
     * @param bool $is_multipids
     * @return $this
     */
    public function setIsMultipids(bool $is_multipids): self
    {
        $this->is_multipids = $is_multipids;
        return $this;
    }


}