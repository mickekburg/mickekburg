<?php

namespace Core\Common\Factory;

abstract class AbstractModuleSettingsFactory
{

    abstract public function getEntityClass(): string;

    abstract public function getEntityGroupClass(): string;

    public function getShowTemplate(): string
    {
        $classes = explode('\\', $this->getEntityClass());
        if (file_exists(TEMPLATE_PATH . "/" . ADMIN_PATH . "/" . end($classes) . "/show.html.twig")) {
            return ADMIN_PATH . "/" . end($classes) . "/show.html.twig";
        }

        return ADMIN_PATH . "/page/show.html.twig";

    }
}