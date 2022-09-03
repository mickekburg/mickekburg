<?php

namespace Core\Widget\Form\View\Field;

class InputFormField extends AbstractFormField
{
    protected $type = '';

    public function render(): string
    {
        $text = '<input type="' . $this->type . '" ';
        if ($this->dto->getIsRequired()) {
            $text .= " required ";
        }
        foreach ($this->dto->getAttrs() as $attr_name => $attr_value) {
            $text .= " " . $attr_name . "='" . $attr_value . "'";
        }
        if ($this->dto->getPlaceholder()) {
            $text .= " placeholder='" . htmlentities($this->dto->getPlaceholder(), ENT_COMPAT | ENT_QUOTES, 'UTF-8', true) . "'";
        }
        if ($this->dto->getName()) {
            $text .= " name='" . $this->dto->getName() . "'";
        }
        $text .= ">";
        return $text;
    }
}