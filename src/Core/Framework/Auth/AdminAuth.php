<?php

namespace Core\Framework\Auth;

use Core\Framework\Auth\DTO\ActionDTO;
use Core\Framework\ModuleInfo\ModuleInfo;
use Module\Login\Sevice\UserLoginService;

class AdminAuth implements IAuth
{

    public static function isAuth(): bool
    {
        return (bool)\Application::i()->getSession()->get(UserLoginService::ADMIN_AUTH_USER_ID);
    }

    public static function canAccess(ModuleInfo $module, ActionDTO $action): bool
    {
        // TODO: Implement canAccess() method.
        return true;
    }
}