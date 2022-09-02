<?php

namespace Core\Framework\Template\Action;

interface ITemplateAction
{
    public function execute(string $input): string;
}