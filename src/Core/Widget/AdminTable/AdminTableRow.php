<?php

namespace Core\Widget\AdminTable;

use Core\Widget\AdminTable\AdminTableCell\AbstractAdminTableCell;
use Core\Widget\Renderable;

class AdminTableRow implements Renderable
{
    /**
     * @var AbstractAdminTableCell[]
     */
    private array $cells = [];

    /**
     * @param AbstractAdminTableCell[] $cells
     */
    public function __construct(array $cells)
    {
        $this->cells = $cells;
    }

    public function render(): string
    {
        if (!empty($this->cells)) {
            $cells_rendered = [];
            foreach ($this->cells as $cell) {
                $cells_rendered[] = $cell->render();
            }
            return "<tr><td>" . implode("</td><td>", $cells_rendered) . "</td></tr>";
        }

        return "";
    }
}