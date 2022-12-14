<?php

namespace Core\Framework\ModuleInfo\DTO;

use InvalidArgumentException;

class ModuleTableTdDTO
{
    protected string $title = "";
    protected string $method = self::METHOD_TEXT;
    protected string $field = "";
    protected bool $is_filter = false;
    protected bool $sort = false;

    public const METHOD_TEXT = 'none';
    public const METHOD_EDIT = 'editTD';
    public const METHOD_SELECT = 'selectTD';
    public const METHOD_CHECKBOX = 'checkboxTD';
    public const METHOD_INPUT = 'inputTD';
    public const METHOD_YES_NO = 'yesNoTD';

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return ModuleTableTdDTO
     */
    public function setTitle(string $title): ModuleTableTdDTO
    {
        $this->title = $title;
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
     * @return ModuleTableTdDTO
     */
    public function setMethod(string $method): ModuleTableTdDTO
    {
        if (!in_array($method, [
            self::METHOD_EDIT,
            self::METHOD_SELECT,
            self::METHOD_CHECKBOX,
            self::METHOD_YES_NO,
            self::METHOD_INPUT,
            self::METHOD_TEXT,
        ])) {
            throw new InvalidArgumentException("Unknown field type");
        } else {
            $this->method = $method;
        }
        return $this;
    }

    /**
     * @return string
     */
    public function getField(): string
    {
        return $this->field;
    }

    /**
     * @param string $field
     * @return $this
     */
    public function setField(string $field): ModuleTableTdDTO
    {
        $this->field = $field;
        return $this;
    }

    /**
     * @return bool
     */
    public function getIsFilter(): bool
    {
        return $this->is_filter;
    }

    /**
     * @param bool $is_filter
     * @return ModuleTableTdDTO
     */
    public function setIsFilter(bool $is_filter): ModuleTableTdDTO
    {
        $this->is_filter = $is_filter;
        return $this;
    }

    /**
     * @return bool
     */
    public function getSort(): bool
    {
        return $this->sort;
    }

    /**
     * @param bool $sort
     * @return $this
     */
    public function setSort(bool $sort): ModuleTableTdDTO
    {
        $this->sort = $sort;
        return $this;
    }


}