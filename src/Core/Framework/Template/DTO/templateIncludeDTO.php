<?php

namespace Core\Framework\Template\DTO;

class templateIncludeDTO
{
    private string $name;
    private int $order;
    private array $attrs;

    public function __construct(string $name, array $attrs, int $order)
    {
        $this->name = $name;
        $this->attrs = $attrs;
        $this->order = $order;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getOrder(): int
    {
        return $this->order;
    }

    /**
     * @return array
     */
    public function getAttrs(): array
    {
        return $this->attrs;
    }


}