<?php

namespace Core\Framework\Router;

use Core\Framework\Auth\IAuth;

class FrontendRouter implements Router
{
    /**
     * @var string[]
     */
    protected array $uri = [];
    protected IAuth $auth;

    /**
     * @param string[] $uri
     */
    public function __construct(array $uri, IAuth $auth)
    {
        $this->uri = $uri;
        $this->auth = $auth;
    }

    public function runController(): void
    {
        // TODO: Implement runController() method.
    }

    public function runError404(): void
    {
        // TODO: Implement runError404() method.
    }
}