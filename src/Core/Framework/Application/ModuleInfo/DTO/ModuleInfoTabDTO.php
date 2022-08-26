<?php

namespace Core\Framework\Application\ModuleInfo\DTO;

class ModuleInfoTabDTO
{
    protected string $title = "";
    protected string $action = "";
    /**
     * @var ModuleFieldDTO[]
     */
    protected array $fields = [];

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return ModuleInfoTabDTO
     */
    public function setName(string $title): ModuleInfoTabDTO
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return array
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    /**
     * @param array $fields
     * @return ModuleInfoTabDTO
     */
    public function setFields(array $fields): ModuleInfoTabDTO
    {
        $this->fields = $fields;
        return $this;
    }

    /**
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }

    /**
     * @param string $action
     * @return ModuleInfoTabDTO
     */
    public function setAction(string $action): ModuleInfoTabDTO
    {
        $this->action = $action;
        return $this;
    }

}