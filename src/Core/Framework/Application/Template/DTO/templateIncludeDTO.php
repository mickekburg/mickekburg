<?php

namespace Core\Framework\Application\Template\DTO;

class templateIncludeDTO
{
    const LAST_ORDER = 9999999;
    private string $name;
    private int $order;

    public function __construct(string $name, int $order)
    {
        $this->name = $name;
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


}