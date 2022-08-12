<?php

namespace Core\Module\AdminTable\Widget;

use Core\Module\AdminTable\DTO\AdminTableColumnDTO;

class AdminTableColumn
{
    protected string $name;
    protected string $title;
    protected bool $is_sorted;
    protected bool $is_filtered;

    /**
     * @param AdminTableColumnDTO $dto
     */
    public function __construct(AdminTableColumnDTO $dto)
    {
        $this->name = $dto->getName();
        $this->title = $dto->getTitle();
        $this->is_sorted = $dto->getIsSorted();
        $this->is_filtered = $dto->getIsFiltered();
    }

    public function getThCell(): string
    {
        return $this->title;
    }

    public function getFilterCell(): string
    {
        return "";
    }

    public function getOrderCell(): string
    {
        return "";
    }


}