<?php

namespace Core\Framework\Auth;

use Core\Framework\Auth\DTO\ActionDTO;
use Core\Framework\ModuleInfo\ModuleInfo;

class Auth implements IAuth
{

    public function isAuth(): bool
    {
        // TODO: Implement isAuth() method.
        return true;
    }

    public function canAccess(ModuleInfo $module, ActionDTO $action): bool
    {
        // TODO: Implement canAccess() method.
        return true;
    }
}