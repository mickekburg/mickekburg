<?php

namespace Core\Widget\AdminTable\Mapper;

class EntityToAdminTableCell
{
    public static function execute($data, callable $function)
    {
        return $function($data);
    }
}