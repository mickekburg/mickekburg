<?php

namespace Core\Framework\Router;

use Core\Framework\Auth\AdminAuth;
use Core\Framework\Auth\Auth;
use Symfony\Component\HttpFoundation\Request;

final class RouterFactory
{
    public static function factory(Request $request): Router
    {
        $parts = explode('/', trim($request->getPathInfo(), '/'));
        return match ($parts[0]) {
            ADMIN_PATH => new AdminRouter($parts, new AdminAuth()),
            default => new FrontendRouter($parts, new Auth()),
        };
    }
}