<?php

namespace Core\Widget\AdminTable\Repository;

use Core\Widget\AdminTable\DTO\AdminTableColumnDTO;
use Core\Widget\AdminTable\View\AdminTableCell\AdminTableCellBold;
use Core\Widget\AdminTable\View\AdminTableCell\AdminTableCellCommon;
use Core\Widget\AdminTable\View\AdminTableColumn;
use Core\Widget\AdminTable\View\AdminTableRow;

class StabAdminTableRepository implements IAdminTableRepository
{
    private $tds_actions = [
        "id" => AdminTableCellCommon::class,
        "name" => AdminTableCellBold::class,
    ];
    private $tds = [
        "id" => "ИД",
        "name" => "Имя",
    ];
    private $trs = [
        [
            "id" => 1,
            "name" => "Иванов",
        ],
        [
            "id" => 2,
            "name" => "Петров",
        ],
    ];

    public function getColumns(): array
    {
        $columns = [];
        foreach ($this->tds_actions as $action_id => $action) {
            $dto = new AdminTableColumnDTO(
                $action_id, $this->tds[$action_id], false, false, $action
            );
            $columns[] = new AdminTableColumn($dto);
        }
        return $columns;
    }

    public function getRows(): array
    {
        $trs = [];
        foreach ($this->trs as $tr) {
            $trs[] = new AdminTableRow($tr);
        }
        return $trs;
    }
}