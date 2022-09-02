<?php

namespace Core\Framework\Auth;

use Core\Framework\Auth\DTO\ActionDTO;
use Core\Framework\ModuleInfo\ModuleInfo;

class AdminAuth implements IAuth
{

    public function isAuth(): bool
    {
        // TODO: Implement isAuth() method.
        return false;
    }

    public function canAccess(ModuleInfo $module, ActionDTO $action): bool
    {
        // TODO: Implement canAccess() method.
        return true;
    }
}