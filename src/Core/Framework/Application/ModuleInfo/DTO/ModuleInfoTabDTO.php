<?php

namespace Core\Framework\Application\ModuleInfo\DTO;

class ModuleInfoTabDTO
{
    protected string $name = "";
    /**
     * @var ModuleFieldDTO[]
     */
    protected array $fields = [];

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return ModuleInfoTabDTO
     */
    public function setName(string $name): ModuleInfoTabDTO
    {
        $this->name = $name;
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

}