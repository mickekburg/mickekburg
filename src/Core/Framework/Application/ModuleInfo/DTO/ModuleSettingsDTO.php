<?php

namespace Core\Framework\Application\ModuleInfo\DTO;

class ModuleSettingsDTO
{
    protected string $title = "";
    protected string $name = "";
    protected string $type = self::TYPE_CHECKBOX;
    protected string $default_value = "";

    public const TYPE_INT = 'int';
    public const TYPE_CHECKBOX = 'checkbox';

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return $this
     */
    public function setType(string $type): self
    {
        if (!in_array($type, [
            self::TYPE_CHECKBOX,
            self::TYPE_INT,
        ])) {
            $this->type = self::TYPE_CHECKBOX;
        } else {
            $this->type = $type;
        }
        return $this;
    }

    /**
     * @return string
     */
    public function getDefaultValue(): string
    {
        return $this->default_value;
    }

    /**
     * @param string $default_value
     * @return $this
     */
    public function setDefaultValue(string $default_value): self
    {
        $this->default_value = $default_value;
        return $this;
    }
}