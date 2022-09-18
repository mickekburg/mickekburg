<?php

namespace Core\Widget\AdminMenu\DTO;

class MenuItemDTO
{
    private string $title;
    private string $href;
    private string $icon = "";
    private bool $is_active = false;
    /**
     * @var MenuItemDTO[]
     */
    private array $subitems = [];

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

    /**
     * @return string
     */
    public function getIcon(): string
    {
        return $this->icon;
    }

    /**
     * @return bool
     */
    public function getIsActive(): bool
    {
        return $this->is_active;
    }

    /**
     * @return MenuItemDTO[]
     */
    public function getSubitems(): array
    {
        return $this->subitems;
    }

    /**
     * @param string $icon
     */
    public function setIcon(string $icon): void
    {
        $this->icon = $icon;
    }

    /**
     * @param bool $is_active
     */
    public function setIsActive(bool $is_active): void
    {
        $this->is_active = $is_active;
    }

    /**
     * @param MenuItemDTO[] $subitems
     */
    public function setSubitems(array $subitems): void
    {
        $this->subitems = $subitems;
    }
}