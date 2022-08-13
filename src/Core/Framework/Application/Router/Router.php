<?php

namespace Core\Framework\Application\Router;

interface Router
{
    /**
     * @param string[] $uri
     */
    public function __construct(array $uri);

    public function runController(): void;

    public function runError404(): void;
}