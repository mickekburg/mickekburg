<?php

namespace Core\Widget\Form\DTO;

class FormResultDTO
{
    private string $name;
    private string $title;
    private ?string $value;


    public function __construct(string $name, string $title, ?string $value)
    {
        $this->name = $name;
        $this->title = $title;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getValue(): ?string
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }
}