<?php

namespace Core\Widget\AdminMenu;

use Core\Widget\AdminMenu\DTO\MenuItemDTO;

class AdminMenuWidget extends \Core\Framework\TwigRenderer implements \Core\Framework\Renderable
{
    protected string $template = "core/widget/admin_menu/admin_menu.html.twig";

    /**
     * @var MenuItemDTO[]
     */
    private array $menu_items;

    private bool $is_superadmin;

    public function __construct(array $menu_items, bool $is_superadmin)
    {
        $this->menu_items = $menu_items;
        $this->is_superadmin = $is_superadmin;
    }

    public function render(): string
    {
        return $this->renderTwig([
            'menu_items' => $this->menu_items,
            'is_superadmin' => $this->is_superadmin,
        ]);
    }
}