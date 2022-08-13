<?php

namespace Core\AdminTable\Widget\AdminTableCell;

class AbstractAdminTableCell implements \Core\Framework\Renderable
{

    protected string $content;
    protected int $row_id;
    protected string $name;

    public function __construct(string $content)
    {
        $this->content = $content;
    }

    public function render(): string
    {
        return $this->content;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @param int $row_id
     */
    public function setRowId(int $row_id): void
    {
        $this->row_id = $row_id;
    }

}