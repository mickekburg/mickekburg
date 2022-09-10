<?php

namespace Core\Framework\ModuleInfo\DTO;

use InvalidArgumentException;

class ModuleFieldDTO
{
    protected string $name = "";
    protected string $title = "";
    protected string $type = "";
    protected bool $is_active = false;
    protected bool $is_required = false;
    protected array $values = [];
    protected string $default_value = "";
    protected string $method = self::TYPE_NONE;

    public const TYPE_NONE = 'none';
    public const TYPE_TEXT = 'text';
    public const TYPE_EMAIL = 'email';
    public const TYPE_PASSWORD = 'password';
    public const TYPE_TEXTAREA = 'textarea';
    public const TYPE_URL = 'url';
    public const TYPE_SELECT = 'select';
    public const TYPE_CHECKBOX = 'checkbox';
    public const TYPE_YES_NO = 'yesno';
    public const TYPE_DATE = 'date';
    public const TYPE_DATETIME = 'datetime';
    public const TYPE_PID = 'pid';
    public const TYPE_CKEDITOR = 'ckeditor';
    public const TYPE_FILE = 'file';
    public const TYPE_GALLERY = 'gallery';

    public const METHOD_FUNCTION = 'function';
    public const METHOD_SEARCH = 'search';
    public const METHOD_TAGS = 'tags';

    public const DATE_NOW = 'NOW';

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return ModuleFieldDTO
     */
    public function setName(string $name): ModuleFieldDTO
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return ModuleFieldDTO
     */
    public function setTitle(string $title): ModuleFieldDTO
    {
        $this->title = $title;
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
     * @return ModuleFieldDTO
     */
    public function setType(string $type): ModuleFieldDTO
    {
        if (!in_array($type, [
            self::TYPE_TEXT,
            self::TYPE_TEXTAREA,
            self::TYPE_URL,
            self::TYPE_SELECT,
            self::TYPE_CHECKBOX,
            self::TYPE_YES_NO,
            self::TYPE_DATE,
            self::TYPE_DATETIME,
            self::TYPE_PID,
            self::TYPE_CKEDITOR,
            self::TYPE_FILE,
            self::TYPE_GALLERY,
            self::TYPE_EMAIL,
            self::TYPE_PASSWORD,
        ])) {
            throw new InvalidArgumentException("Unknown field type");
        } else {
            $this->type = $type;
        }
        return $this;
    }

    /**
     * @return bool
     */
    public function getIsActive(): bool
    {
        return $this->is_active;
    }

    /**
     * @param bool $is_active
     * @return ModuleFieldDTO
     */
    public function setIsActive(bool $is_active): ModuleFieldDTO
    {
        $this->is_active = $is_active;
        return $this;
    }

    /**
     * @return array
     */
    public function getValues(): array
    {
        return $this->values;
    }

    /**
     * @param array $values
     * @return ModuleFieldDTO
     */
    public function setValues(array $values): ModuleFieldDTO
    {
        $this->values = $values;
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
     * @return ModuleFieldDTO
     */
    public function setDefaultValue(string $default_value): ModuleFieldDTO
    {
        $this->default_value = $default_value;
        return $this;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @param string $method
     * @return ModuleFieldDTO
     */
    public function setMethod(string $method): ModuleFieldDTO
    {
        if (!in_array($method, [
            self::METHOD_FUNCTION,
            self::METHOD_SEARCH,
            self::METHOD_TAGS,
            self::TYPE_NONE,
        ])) {
            throw new InvalidArgumentException("Unknown field type");
        } else {
            $this->method = $method;
        }
        return $this;
    }

    /**
     * @return bool
     */
    public function getIsRequired(): bool
    {
        return $this->is_required;
    }

    /**
     * @param bool $is_required
     * @return $this
     */
    public function setIsRequired(bool $is_required): ModuleFieldDTO
    {
        $this->is_required = $is_required;
        return $this;
    }


}