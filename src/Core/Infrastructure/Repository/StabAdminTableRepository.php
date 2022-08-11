<?php

namespace Core\Infrastructure\Repository;

use Core\BusinessLogic\Repository\IAdminTableRepository;

class StabAdminTableRepository implements IAdminTableRepository
{
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
        // TODO: Implement getColumns() method.
        return [];
    }

    public function getRows(): array
    {
        // TODO: Implement getRows() method.
        return [];
    }
}