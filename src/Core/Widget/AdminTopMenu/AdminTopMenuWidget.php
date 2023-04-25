<?php

namespace Core\Widget\AdminTopMenu;

use Core\Widget\AdminTopMenu\DTO\AdminTopMenuDTO;

class AdminTopMenuWidget extends \Core\Framework\TwigRenderer implements \Core\Framework\Renderable
{
    protected string $template = "core/widget/admin_top_menu/admin_top_menu.html.twig";

    /**
     * @var AdminTopMenuDTO[]
     */
    private array $top_menu_items;

    public function __construct(array $top_menu_items)
    {
        $this->top_menu_items = $top_menu_items;
    }

    public function render(): string
    {
        return $this->renderTwig([
            'top_menu_items' => $this->top_menu_items,
        ]);
    }
}