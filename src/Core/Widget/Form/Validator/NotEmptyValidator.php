<?php

namespace Core\Widget\Form\Validator;

class NotEmptyValidator extends FormFieldValidator
{
    public function isValid(?string $value): bool
    {
        return !empty($value);
    }
}