<?php

namespace Core\Module\AdminTable\Widget;

use Core\Renderable;
use Core\TwigRenderer;

class AdminTable extends TwigRenderer implements Renderable
{
    /**
     * @var AdminTableColumn[]
     */
    private array $columns = [];

    /**
     * @var AdminTableRow[]
     */
    private array $rows = [];

    protected string $template = "Core/Widget/AdminTable/AdminTable.html";

    /**
     * @param AdminTableColumn[] $columns
     * @param AdminTableRow[] $rows
     */
    public function __construct(array $columns, array $rows, string $template = "")
    {
        $this->columns = $columns;
        $this->rows = $rows;
        if ($template) {
            $this->template = $template;
        }
    }

    public function render(): string
    {
        $rows_rendered = [];
        foreach ($this->rows as $row) {
            $rows_rendered[] = $row->render();
        }

        $cols_rendered = [];
        foreach ($this->columns as $column) {
            $cols_rendered[] = [
                'th' => $column->getThCell(),
                'filter' => $column->getFilterCell(),
                'order' => $column->getOrderCell(),
            ];
        }

        return $this->renderTwig([
            'rows' => $rows_rendered,
            'columns' => $cols_rendered,
        ]);
    }


}