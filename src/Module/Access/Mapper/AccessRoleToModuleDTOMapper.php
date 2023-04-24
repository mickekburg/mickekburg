<?php

namespace Module\Access\Mapper;

use Module\Access\DTO\AccessModuleDTO;
use Module\Access\Entity\AccessModuleRole;

final class AccessRoleToModuleDTOMapper
{
    public static function map(AccessModuleRole $role): AccessModuleDTO
    {
        $can_add = $role->getCanAdd();
        $can_edit = $role->getCanEdit();
        $can_view = $role->getCanView();
        $can_delete = $role->getCanDelete();
        return new AccessModuleDTO($can_add, $can_edit, $can_view, $can_delete);
    }

    public static function joinDTO(AccessModuleDTO $parent_dto, ?AccessModuleDTO $child_dto): AccessModuleDTO
    {
        if (empty($child_dto)) {
            return $parent_dto;
        }
        $can_add = $child_dto->getCanAdd() == AccessModuleRole::INHERIT ? $parent_dto->getCanAdd() : $child_dto->getCanAdd();
        $can_edit = $child_dto->getCanEdit() == AccessModuleRole::INHERIT ? $parent_dto->getCanEdit() : $child_dto->getCanEdit();
        $can_view = $child_dto->getCanView() == AccessModuleRole::INHERIT ? $parent_dto->getCanView() : $child_dto->getCanView();
        $can_delete = $child_dto->getCanDelete() == AccessModuleRole::INHERIT ? $parent_dto->getCanDelete() : $child_dto->getCanDelete();
        return new AccessModuleDTO($can_add, $can_edit, $can_view, $can_delete);
    }
}