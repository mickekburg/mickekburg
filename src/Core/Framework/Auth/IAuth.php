<?php

namespace Core\Framework\Auth;

use Core\Framework\Auth\DTO\ActionDTO;
use Core\Framework\ModuleInfo\ModuleInfo;

interface IAuth
{
    public function isAuth(): bool;
    public function canAccess(ModuleInfo $module, ActionDTO $action): bool;
}