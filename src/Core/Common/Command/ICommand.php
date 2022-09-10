<?php

namespace Core\Common\Command;

interface ICommand
{
    public function execute(): void;

    public function getResult(): void;
}