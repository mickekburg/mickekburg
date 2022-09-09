<?php

namespace Core\Framework\ModuleInfo\Mapper;

use Core\Framework\ModuleInfo\ModuleInfo;

final class ModuleInfoArrayToEntityDirMapper
{
    /**
     * @param array $module_info_array
     * @return array
     */
    public static function map(array $module_info_array): array
    {
        $result = [];
        foreach ($module_info_array as $module_directory => $module_info) {
            $entity_folder = $module_info->getEntityFolder();
            if (!is_null($entity_folder)) {
                $result[] = $entity_folder;
            }
        }
        return $result;
    }
}