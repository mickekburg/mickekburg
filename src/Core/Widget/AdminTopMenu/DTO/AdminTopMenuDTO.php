<?php

namespace Core\Widget\AdminTopMenu\DTO;

class AdminTopMenuDTO
{
    private string $title;
    private string $href;

    public function __construct(string $title, string $href)
    {
        $this->title = $title;
        $this->href = $href;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getHref(): string
    {
        return $this->href;
    }


}