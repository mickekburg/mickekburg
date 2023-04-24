<?php

namespace Core\Widget\AdminMenu;

use Core\Widget\AdminMenu\DTO\MenuItemDTO;

class AdminMenuWidget extends \Core\Framework\TwigRenderer implements \Core\Framework\Renderable
{
    /**
     * @var MenuItemDTO[]
     */
    private array $menu_items = [];

    public function __construct(array $menu_items)
    {
        $this->menu_items = $menu_items;
    }

    public function render(): string
    {
        return "1234";
    }
}