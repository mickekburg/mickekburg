<?php

namespace Core\Widget\Form\DTO;

use Core\Widget\Form\Filter\IFormFieldFilter;
use Core\Widget\Form\Validator\FormFieldValidator;
use InvalidArgumentException;

class FormFieldDTO
{
    protected string $name = "";
    protected string $title = "";
    protected string $type = "";
    protected bool $is_required = false;
    protected array $values = [];
    protected string $value = "";
    protected string $placeholder = "";
    protected array $attrs = [];
    /**
     * @var FormFieldValidator[]
     */
    protected array $validators = [];
    /**
     * @var IFormFieldFilter[]
     */
    protected array $filters = [];

    public const TYPE_TEXT = 'text';
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
    public const TYPE_PASSWORD = 'password';
    public const TYPE_HIDDEN = 'hidden';
    public const TYPE_GALLERY = 'gallery';

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return FormFieldDTO
     */
    public function setName(string $name): FormFieldDTO
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
     * @return FormFieldDTO
     */
    public function setTitle(string $title): FormFieldDTO
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
     * @return FormFieldDTO
     */
    public function setType(string $type): FormFieldDTO
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
            self::TYPE_PASSWORD,
            self::TYPE_HIDDEN,
        ])) {
            throw new InvalidArgumentException("Unknown field type");
        } else {
            $this->type = $type;
        }
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
     * @return FormFieldDTO
     */
    public function setValues(array $values): FormFieldDTO
    {
        $this->values = $values;
        return $this;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $value
     * @return FormFieldDTO
     */
    public function setValue(string $value): FormFieldDTO
    {
        $this->value = $value;
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
    public function setIsRequired(bool $is_required): FormFieldDTO
    {
        $this->is_required = $is_required;
        return $this;
    }

    /**
     * @return string
     */
    public function getPlaceholder(): string
    {
        return $this->placeholder;
    }

    /**
     * @param string $placeholder
     * @return $this
     */
    public function setPlaceholder(string $placeholder): FormFieldDTO
    {
        $this->placeholder = $placeholder;
        return $this;
    }

    /**
     * @return array
     */
    public function getAttrs(): array
    {
        return $this->attrs;
    }

    /**
     * @param array $attrs
     * @return $this
     */
    public function setAttrs(array $attrs): FormFieldDTO
    {
        $this->attrs = $attrs;
        return $this;
    }

    /**
     * @return FormFieldValidator[]
     */
    public function getValidators(): array
    {
        return $this->validators;
    }

    /**
     * @param FormFieldValidator $validators
     * @return $this
     */
    public function addValidator(FormFieldValidator $validator): FormFieldDTO
    {
        $this->validators[] = $validator;
        return $this;
    }

    /**
     * @return IFormFieldFilter[]
     */
    public function getFilters(): array
    {
        return $this->filters;
    }

    /**
     * @param IFormFieldFilter $filter
     * @return $this
     */
    public function addFilter(FormFieldValidator $filter): FormFieldDTO
    {
        $this->filters[] = $filter;
        return $this;
    }


}