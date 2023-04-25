<?php

namespace Core\Widget\AdminMenu\Mapper;

use Core\Framework\Helper\UrlHelper;
use Core\Widget\AdminMenu\DTO\MenuItemDTO;
use Module\Access\Entity\AccessModule;

final class AdminMenuWidgetMapper
{
    private const EMPTY_HREF = '#';

    /**
     * @param AccessModule[] $menu_items
     * @param string $active_module_name
     * @return MenuItemDTO[]
     */
    public static function mapAccessModule(array $menu_items, string $active_module_name = ""): array
    {
        $result = [];
        $result_children = [];
        foreach ($menu_items as $menu_item) {
            $url = $menu_item->getModuleName() ? UrlHelper::siteUrl(ADMIN_PATH . '/' . strtolower($menu_item->getModuleName())) : self::EMPTY_HREF;
            $menu_item_dto = new MenuItemDTO($menu_item->getName(), $url);
            if ($menu_item->getModuleName() === $active_module_name) {
                $menu_item_dto->setIsActive(true);
            }
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
                foreach ($subitems as $subitem) {
                    if ($subitem->getIsActive()) {
                        $result[$parent_id]->setIsActive(true);
                        break;
                    }
                }
                $result[$parent_id]->setSubitems($subitems);
            }
        }

        $result = array_values($result);
        return array_filter($result, fn($menu_item_dto) => $menu_item_dto->getHref() !== self::EMPTY_HREF || !empty($menu_item_dto->getSubitems()));
    }
}