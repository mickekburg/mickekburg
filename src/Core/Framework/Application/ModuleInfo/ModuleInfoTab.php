<?php

namespace Core\Framework\Application\ModuleInfo;

class ModuleInfoTab
{
    protected string $name;
    protected array $fields = [];

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @param array $fields
     */
    public function setFields(array $fields): void
    {
        $this->fields = $fields;
    }
}