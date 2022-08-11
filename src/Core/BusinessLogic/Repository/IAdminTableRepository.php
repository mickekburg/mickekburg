<?php

namespace Core\BusinessLogic\Repository;

use Core\Widget\AdminTable\AdminTableCell\AbstractAdminTableCell;

interface IAdminTableRepository
{
    /**
     * return AbstractAdminTableCell[]
     */
    public function getColumns() : array;

    /**
     * return AbstractAdminTableCell[]
     */
    public function getRows() : array;

}