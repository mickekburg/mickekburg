<?php

namespace Core\Widget\Form\Validator;

abstract class FormFieldValidator
{
    protected string $error;

    public function __construct(string $error)
    {
        $this->error = $error;
    }

    public abstract function isValid(?string $value): bool;

    /**
     * @return string
     */
    public function getError(): string
    {
        return $this->error;
    }
}