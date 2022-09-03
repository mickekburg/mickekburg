<?php

namespace Core\Widget\Form\Factory;

use Core\Widget\Form\DTO\FormFieldDTO;
use Core\Widget\Form\View\Field\AbstractFormField;
use Core\Widget\Form\View\Field\CheckboxField;
use Core\Widget\Form\View\Field\InputHiddenField;
use Core\Widget\Form\View\Field\PasswordField;
use Core\Widget\Form\View\Field\TextFormField;
use InvalidArgumentException;

final class FormFieldFactory
{
    public static function getFieldView(FormFieldDTO $dto): AbstractFormField
    {
        return match ($dto->getType()) {
            FormFieldDTO::TYPE_TEXT => new TextFormField($dto),
            FormFieldDTO::TYPE_PASSWORD => new PasswordField($dto),
            FormFieldDTO::TYPE_CHECKBOX => new CheckboxField($dto),
            FormFieldDTO::TYPE_HIDDEN => new InputHiddenField($dto),
            default => throw new InvalidArgumentException("Unknown field type"),
        };
    }
}