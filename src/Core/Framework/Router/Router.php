<?php

namespace Core\Framework\Router;

use Core\Framework\Auth\IAuth;

interface Router
{
    /**
     * @param string[] $uri
     */
    public function __construct(array $uri, IAuth $auth);

    public function runController(): void;

    public function runError404(): void;

}