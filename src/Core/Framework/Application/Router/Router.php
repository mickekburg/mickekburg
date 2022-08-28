<?php

namespace Core\Framework\Application\Router;

use Core\Framework\Application\Auth\IAuth;

interface Router
{
    /**
     * @param string[] $uri
     */
    public function __construct(array $uri, IAuth $auth);

    public function runController(): void;

    public function runError404(): void;

}