<?php

namespace Core\Framework\ModuleInfo\Factory;

interface IConfigCreator
{
    public function createConfig(): string;
}