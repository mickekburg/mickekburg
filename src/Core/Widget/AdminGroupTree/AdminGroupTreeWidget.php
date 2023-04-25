<?php

namespace Core\Widget\AdminGroupTree;


use Core\Common\Repository\ICommonRepository;
use Module\Access\DTO\AccessModuleDTO;

class AdminGroupTreeWidget extends \Core\Framework\TwigRenderer implements \Core\Framework\Renderable
{
    protected string $template = "core/widget/admin_group_tree/admin_group_tree.html.twig";

    private ICommonRepository $repository;
    private ?int $current_node;
    private AccessModuleDTO $access_module_dto;

    public function __construct(ICommonRepository $repository, ?int $current_node, AccessModuleDTO $access_module_dto)
    {
        $this->repository = $repository;
        $this->current_node = $current_node;
        $this->access_module_dto = $access_module_dto;
    }

    public function render(): string
    {
        return $this->renderTwig([

        ]);
    }
}