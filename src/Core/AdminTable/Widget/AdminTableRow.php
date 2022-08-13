<?php

namespace Core\AdminTable\Widget;

use Core\Framework\Renderable;

class AdminTableRow implements Renderable
{
    /**
     * @var array
     */
    private array $cells = [];

    /**
     * @param array $cells
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
                $cells_rendered[] = $cell;
            }
            return "<tr><td>" . implode("</td><td>", $cells_rendered) . "</td></tr>";
        }

        return "";
    }
}