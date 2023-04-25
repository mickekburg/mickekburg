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
    private bool $has_superadmin_role;

    public function __construct(array $menu_items, bool $is_superadmin, bool $has_superadmin_role)
    {
        $this->menu_items = $menu_items;
        $this->has_superadmin_role = $has_superadmin_role;
        $this->is_superadmin = $is_superadmin;
    }

    public function render(): string
    {
        return $this->renderTwig([
            'menu_items' => $this->menu_items,
            'has_superadmin_role' => $this->has_superadmin_role,
            'is_superadmin' => $this->is_superadmin,
        ]);
    }
}