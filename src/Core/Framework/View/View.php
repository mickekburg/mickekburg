<?php

namespace Core\Framework\View;

class View
{
    private string $filename = "";
    private array $args = [];

    public function __construct(string $path, array $args)
    {

    }

    public function render(): string
    {
        return "aaaa1234";
    }

}