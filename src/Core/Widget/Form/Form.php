<?php

namespace Core\Widget\Form;

use Core\Widget\Form\DTO\FormFieldDTO;
use Core\Widget\Form\DTO\FormResultDTO;
use Core\Widget\Form\Mapper\FormFieldToViewMapper;
use Core\Widget\Form\Validator\FormFieldValidator;
use Core\Widget\Form\Validator\NotEmptyValidator;

class Form extends \Core\Framework\TwigRenderer implements \Core\Framework\Renderable
{

    /**
     * @var FormFieldDTO[]
     */
    protected array $fields;
    protected string $form_id;

    /**
     * @var FormResultDTO[]
     */
    protected array $result = [];
    /**
     * @var FormResultDTO[]
     */
    protected array $errors = [];

    /**
     * @param string $form_id
     * @param FormFieldDTO[] $fields
     * @param string $template
     */
    public function __construct(string $form_id, array $fields, string $template)
    {
        $this->form_id = $form_id;
        $this->fields = $fields;
        foreach ($this->fields as $field) {
            if ($field->getIsRequired()) {
                $field->addValidator(new NotEmptyValidator(
                    str_replace('{field}', $field->getTitle(), \Application::i()->getTranslator()->trans('form.validation.not_empty'))
                ));
            }
        }
        $this->template = $template;
    }

    public function bindValidator(string $field_name, FormFieldValidator $validator): void
    {
        foreach ($this->fields as $field) {
            if ($field->getName() == $field_name) {
                $field->addValidator($validator);
                break;
            }
        }
    }

    public function render(): string
    {
        return $this->renderTwig([
            'fields' => (new FormFieldToViewMapper())->mapFormFieldsToViews($this->fields),
            'form_id' => $this->form_id,
        ]);
    }

    public function isSubmitted(): bool
    {
        return \Application::i()->getRequest()->get($this->form_id) ? true : false;
    }

    public function process(): bool
    {
        foreach ($this->fields as $field) {
            $value = \Application::i()->getRequest()->get($field->getName());
            foreach ($field->getFilters() as $filter) {
                $value = $filter->filter($value);
            }
            $was_error = false;
            foreach ($field->getValidators() as $validator) {
                if (!$validator->isValid($value)) {
                    $this->errors[] = new FormResultDTO($field->getName(), $field->getTitle(), $validator->getError());
                    $was_error = true;
                }
            }
            if (!$was_error) {
                $this->result[] = new FormResultDTO($field->getName(), $field->getTitle(), $value);
            }
        }
        return empty($this->errors);
    }

    /**
     * @return FormResultDTO[]
     */
    public function getResult(): array
    {
        return $this->result;
    }

    /**
     * @return FormResultDTO[]
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

}