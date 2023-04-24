<?php

namespace Core\Widget\AdminMenu\Mapper;

use Core\Framework\Helper\UrlHelper;
use Core\Widget\AdminMenu\DTO\MenuItemDTO;
use Module\Access\Entity\AccessModule;

final class AdminMenuWidgetMapper
{
    /**
     * @param AccessModule[] $menu_items
     * @return MenuItemDTO[]
     */
    public static function mapAccessModule(array $menu_items): array
    {
        $result = [];
        $result_children = [];
        foreach ($menu_items as $menu_item) {
            $url = $menu_item->getModuleName() ? UrlHelper::siteUrl(ADMIN_PATH . '/' . strtolower($menu_item->getModuleName())) : "#";
            $menu_item_dto = new MenuItemDTO($menu_item->getName(), $url);
            $menu_item_dto->setIcon($menu_item->getModuleIcon());
            if ($menu_item->getParent()) {
                if (empty($result_children[$menu_item->getParent()->getId()])) {
                    $result_children[$menu_item->getParent()->getId()] = [];
                }
                $result_children[$menu_item->getParent()->getId()][] = $menu_item_dto;
            } else {
                $result[$menu_item->getId()] = $menu_item_dto;
            }
        }

        foreach ($result_children as $parent_id => $subitems) {
            if (!empty($result[$parent_id])) {
                $result[$parent_id]->setSubitems($subitems);
            }
        }
        return array_values($result);
    }
}