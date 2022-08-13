<?php

namespace Core\Framework\Application\Router;

class FrontendRouter implements Router
{
    /**
     * @var string[]
     */
    protected array $uri = [];

    /**
     * @param string[] $uri
     */
    public function __construct(array $uri)
    {
        $this->uri = $uri;
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