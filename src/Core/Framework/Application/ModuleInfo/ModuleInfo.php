<?php

namespace Core\Framework\Application\ModuleInfo;

use Core\Framework\Application\Controller\BaseAdminController;

class ModuleInfo
{
    protected string $module_name;
    protected string $literal_name;
    protected string $default_order;
    /**
     * @var ModuleInfoTab[]
     */
    protected array $tabs = [];
    protected array $fieldsTds = [];
    protected array $settings = [];
    protected string $actions = "";
    protected array $fields_group = [];

    /**
     * @param string $module_name
     */
    public function setModuleName(string $module_name): void
    {
        $this->module_name = $module_name;
    }

    /**
     * @param string $literal_name
     */
    public function setLiteralName(string $literal_name): void
    {
        $this->literal_name = $literal_name;
    }

    /**
     * @param string $default_order
     */
    public function setDefaultOrder(string $default_order): void
    {
        $this->default_order = $default_order;
    }

    /**
     * @param ModuleInfoTab[] $tabs
     */
    public function setTabs(array $tabs): void
    {
        foreach($tabs as $tab){
            $this->tabs[] = new ModuleInfoTab();
        }
    }

    /**
     * @param array $fieldsTds
     */
    public function setFieldsTds(array $fieldsTds): void
    {
        $this->fieldsTds = $fieldsTds;
    }

    /**
     * @param array $settings
     */
    public function setSettings(array $settings): void
    {
        $this->settings = $settings;
    }

    /**
     * @param string $actions
     */
    public function setActions(string $actions): void
    {
        $this->actions = $actions;
    }

    /**
     * @param array $fields_group
     */
    public function setFieldsGroup(array $fields_group): void
    {
        $this->fields_group = $fields_group;
    }

    public function init(): void
    {

    }

    public function getAdminController(): BaseAdminController
    {
        $controller_name = "\Module\\" . $this->module_name . "\\AdminController";
        return new $controller_name();
    }


}