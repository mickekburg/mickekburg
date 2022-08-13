<?php

namespace Core\AdminTable\DTO;

class AdminTableColumnDTO
{
    protected string $name;
    protected string $title;
    protected bool $is_sorted;
    protected bool $is_filtered;
    protected string $action;

    public function __construct(string $name, string $title, bool $is_sorted, bool $is_filtered, string $action)
    {
        $this->name = $name;
        $this->title = $title;
        $this->is_sorted = $is_sorted;
        $this->is_filtered = $is_filtered;
        $this->action = $action;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return bool
     */
    public function getIsSorted(): bool
    {
        return $this->is_sorted;
    }

    /**
     * @return bool
     */
    public function getIsFiltered(): bool
    {
        return $this->is_filtered;
    }

    /**
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }

}