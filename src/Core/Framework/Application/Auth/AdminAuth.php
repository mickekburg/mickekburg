<?php

namespace Core\Framework\Application\Auth;

use Core\Framework\Application\Auth\DTO\ActionDTO;
use Core\Framework\Application\ModuleInfo\ModuleInfo;

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