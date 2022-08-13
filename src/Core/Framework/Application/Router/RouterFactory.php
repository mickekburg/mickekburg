<?php

namespace Core\Framework\Application\Router;

use Symfony\Component\HttpFoundation\Request;

final class RouterFactory
{
    public static function factory(Request $request): Router
    {
        $parts = explode('/', trim($request->getPathInfo(), '/'));
        return match ($parts[0]) {
            ADMIN_PATH => new AdminRouter($parts),
            default => new FrontendRouter($parts),
        };
    }
}