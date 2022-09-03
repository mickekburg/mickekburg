<?php

namespace Core\Widget\Form\View\Field;

use Core\Framework\Renderable;
use Core\Widget\Form\DTO\FormFieldDTO;

abstract class AbstractFormField implements Renderable
{
    protected FormFieldDTO $dto;

    public function __construct(FormFieldDTO $dto)
    {
        $this->dto = $dto;
    }
}