<?php

namespace Module\Access\DTO;

use Module\Access\Entity\AccessModuleRole;

class AccessModuleDTO
{
    private int $can_add = AccessModuleRole::DENY;
    private int $can_edit = AccessModuleRole::DENY;
    private int $can_view = AccessModuleRole::DENY;
    private int $can_delete = AccessModuleRole::DENY;

    public function __construct(int $can_add, int $can_edit, int $can_view, int $can_delete)
    {
        $this->can_add = $can_add;
        $this->can_edit = $can_edit;
        $this->can_view = $can_view;
        $this->can_delete = $can_delete;
    }

    /**
     * @return int
     */
    public function getCanAdd(): int
    {
        return $this->can_add;
    }

    /**
     * @return int
     */
    public function getCanEdit(): int
    {
        return $this->can_edit;
    }

    /**
     * @return int
     */
    public function getCanView(): int
    {
        return $this->can_view;
    }

    /**
     * @return int
     */
    public function getCanDelete(): int
    {
        return $this->can_delete;
    }
}