<?php

namespace Core\Widget\Form\Filter;

interface IFormFieldFilter
{
    public function filter($value): mixed;

}