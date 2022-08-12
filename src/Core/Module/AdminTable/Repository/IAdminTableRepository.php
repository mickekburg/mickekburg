<?php

namespace Core\Module\AdminTable\Repository;

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