<?php

namespace Core\Framework\Application\ModuleInfo\Factory;

interface IConfigCreator
{
    public function createConfig(): string;
}