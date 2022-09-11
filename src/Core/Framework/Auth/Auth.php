<?php

namespace Core\Framework\Auth;

use Core\Framework\Auth\DTO\ActionDTO;
use Core\Framework\ModuleInfo\ModuleInfo;

class Auth implements IAuth
{

    public static function isAuth(): bool
    {
        // TODO: Implement isAuth() method.
        return true;
    }

    public static function canAccess(ModuleInfo $module, ActionDTO $action): bool
    {
        // TODO: Implement canAccess() method.
        return true;
    }
}