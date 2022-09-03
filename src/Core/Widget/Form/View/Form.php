<?php

namespace Core\Widget\Form\View;

use Core\Widget\Form\DTO\FormFieldDTO;
use Core\Widget\Form\Mapper\FormFieldToViewMapper;

class Form extends \Core\Framework\TwigRenderer implements \Core\Framework\Renderable
{

    /**
     * @var FormFieldDTO[]
     */
    protected array $fields;

    /**
     * @param FormFieldDTO[] $fields
     * @param string $template
     */
    public function __construct(array $fields, string $template)
    {
        $this->fields = $fields;
        $this->template = $template;
    }

    public function render(): string
    {
        return $this->renderTwig([
            'fields'=> (new FormFieldToViewMapper())->mapFormFieldsToViews($this->fields),
        ]);
    }
}