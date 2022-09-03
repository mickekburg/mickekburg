<?php

namespace Core\Widget\Form\Mapper;

use Core\Widget\Form\DTO\FormFieldDTO;
use Core\Widget\Form\Factory\FormFieldFactory;

class FormFieldToViewMapper
{
    /**
     * @param FormFieldDTO[] $fields
     * @return array
     */
    public function mapFormFieldsToViews(array $fields): array
    {
        $result = [];
        foreach ($fields as $field) {
            $filed_view = FormFieldFactory::getFieldView($field);
            $result[$field->getName()] = $filed_view->render();
        }
        return $result;
    }
}