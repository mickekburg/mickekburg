<?php

namespace Core\Widget\AdminTable\Repository;

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