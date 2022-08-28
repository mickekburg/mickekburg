<?php

namespace Core\Framework\Application\Auth;

use Core\Framework\Application\Auth\DTO\ActionDTO;
use Core\Framework\Application\ModuleInfo\ModuleInfo;

interface IAuth
{
    public function isAuth(): bool;
    public function canAccess(ModuleInfo $module, ActionDTO $action): bool;
}