<?php

namespace Core\Widget\AdminTable;

use Core\Widget\AdminTable\DTO\AdminTableColumnDTO;

class AdminTableColumn
{
    protected string $name;
    protected string $title;
    protected bool $is_sorted;
    protected bool $is_filtered;

    public function __construct(string $name, string $title, bool $is_sorted = false, bool $is_filtered = false)
    {
        $this->name = $name;
        $this->title = $title;
        $this->is_sorted = $is_sorted;
        $this->is_filtered = $is_filtered;
    }

    public function getAdminTableColumnDTO()
    {
        //TODO: Вставить нормальные сортировки и фильтры
        return new AdminTableColumnDTO($this->title, "", "");
    }


}