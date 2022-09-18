<?php

namespace Core\Widget\AdminMenu;

class AdminMenu extends \Core\Framework\TwigRenderer implements \Core\Framework\Renderable
{

    private array $menu_items = [];

    public function render(): string
    {
        return "";
    }
}