<?php

namespace Core\Framework\Auth;

use Core\Framework\Auth\DTO\ActionDTO;
use Core\Framework\ModuleInfo\ModuleInfo;

interface IAuth
{
    public static function isAuth(): bool;
    public static function canAccess(ModuleInfo $module, ActionDTO $action): bool;
}