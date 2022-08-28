<?php

namespace Core\Framework\Application\Auth;

use Core\Framework\Application\Auth\DTO\ActionDTO;
use Core\Framework\Application\ModuleInfo\ModuleInfo;

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