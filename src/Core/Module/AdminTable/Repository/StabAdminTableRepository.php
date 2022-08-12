<?php

namespace Core\Module\AdminTable\Repository;

use Core\Module\AdminTable\DTO\AdminTableColumnDTO;
use Core\Module\AdminTable\Widget\AdminTableCell\AdminTableCellBold;
use Core\Module\AdminTable\Widget\AdminTableCell\AdminTableCellCommon;
use Core\Module\AdminTable\Widget\AdminTableColumn;
use Core\Module\AdminTable\Widget\AdminTableRow;

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