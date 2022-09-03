<?php

namespace Core\Widget\Form\View\Field;

class InputHiddenField extends AbstractFormField
{
    public function render(): string
    {
        $text = '<input type="hidden" ';
        if ($this->dto->getValue()) {
            $text .= " value='" . htmlentities($this->dto->getValue(), ENT_COMPAT | ENT_QUOTES, 'UTF-8', true) . "'";
        }
        if ($this->dto->getName()) {
            $text .= " name='" . $this->dto->getName() . "'";
        }
        $text .= ">";
        return $text;
    }
}