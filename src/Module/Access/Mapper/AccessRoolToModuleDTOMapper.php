<?php

namespace Module\Access\Mapper;

use Module\Access\DTO\AccessModuleDTO;
use Module\Access\Entity\AccessModuleRool;

final class AccessRoolToModuleDTOMapper
{
    public static function map(AccessModuleRool $rool): AccessModuleDTO
    {
        $can_add = $rool->getCanAdd();
        $can_edit = $rool->getCanEdit();
        $can_view = $rool->getCanView();
        $can_delete = $rool->getCanDelete();
        return new AccessModuleDTO($can_add, $can_edit, $can_view, $can_delete);
    }

    public static function joinDTO(AccessModuleDTO $parent_dto, ?AccessModuleDTO $child_dto): AccessModuleDTO
    {
        if (empty($child_dto)) {
            return $parent_dto;
        }
        $can_add = $child_dto->getCanAdd() == AccessModuleRool::INHERIT ? $parent_dto->getCanAdd() : $child_dto->getCanAdd();
        $can_edit = $child_dto->getCanEdit() == AccessModuleRool::INHERIT ? $parent_dto->getCanEdit() : $child_dto->getCanEdit();
        $can_view = $child_dto->getCanView() == AccessModuleRool::INHERIT ? $parent_dto->getCanView() : $child_dto->getCanView();
        $can_delete = $child_dto->getCanDelete() == AccessModuleRool::INHERIT ? $parent_dto->getCanDelete() : $child_dto->getCanDelete();
        return new AccessModuleDTO($can_add, $can_edit, $can_view, $can_delete);
    }
}