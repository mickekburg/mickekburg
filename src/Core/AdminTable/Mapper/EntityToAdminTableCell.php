<?php

namespace Core\AdminTable\Mapper;

class EntityToAdminTableCell
{
    public static function execute($data, callable $function)
    {
        return $function($data);
    }
}