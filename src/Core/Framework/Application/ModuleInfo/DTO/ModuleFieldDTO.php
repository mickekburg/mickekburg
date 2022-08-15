<?php

namespace Core\Framework\Application\ModuleInfo\DTO;

class ModuleFieldDTO
{
    protected string $name;
    protected string $title;
    protected string $type;
    protected bool $is_active;
    protected array $values;
    protected string $default_value;
    protected string $method;

    public const TYPE_TEXT = 'text';
    public const TYPE_TEXTAREA = 'textarea';
    public const TYPE_URL = 'url';
    public const TYPE_SELECT = 'select';
    public const TYPE_CHECKBOX = 'checkbox';
    public const TYPE_YESNO = 'yesno';
    public const TYPE_DATE = 'date';
    public const TYPE_DATETIME = 'datetime';
    public const TYPE_PID = 'pid';
    public const TYPE_CKEDITOR = 'ckeditor';
    public const TYPE_FILE = 'file';
    public const TYPE_GALLERY = 'gallery';

    public const METHOD_FUNCTION = 'function';
    public const METHOD_SEARCH = 'search';
    public const METHOD_TAGS = 'tags';

    public function __construct(string $name, string $title, string $type, bool $is_active = false, string $values = "", string $default_value = "", string $method = "")
    {
        $this->setName($name);
        $this->setTitle($title);
        $this->setType($type);
        $this->setIsActive($is_active);
        $this->setValues($values);
        $this->setDefaultValue($default_value);
        $this->setMethod($method);
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
     */
    public function setName(string $name): void
    {
        $this->name = $name;
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
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
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
     */
    public function setType(string $type): void
    {
        if (!in_array($type, [
            self::TYPE_TEXT,
            self::TYPE_TEXTAREA,
            self::TYPE_URL,
            self::TYPE_SELECT,
            self::TYPE_CHECKBOX,
            self::TYPE_YESNO,
            self::TYPE_DATE,
            self::TYPE_DATETIME,
            self::TYPE_PID,
            self::TYPE_CKEDITOR,
            self::TYPE_FILE,
            self::TYPE_GALLERY,
        ])) {
            $this->type = self::TYPE_TEXT;
        } else {
            $this->type = $type;
        }
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
     */
    public function setIsActive(bool $is_active): void
    {
        $this->is_active = $is_active;
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
     */
    public function setValues(array $values): void
    {
        $this->values = $values;
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
     */
    public function setDefaultValue(string $default_value): void
    {
        $this->default_value = $default_value;
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
     */
    public function setMethod(string $method): void
    {
        if (!in_array($method, [
            self::METHOD_FUNCTION,
            self::METHOD_SEARCH,
            self::METHOD_TAGS,
        ])) {
            $this->method = self::METHOD_FUNCTION;
        } else {
            $this->method = $method;
        }
    }


}