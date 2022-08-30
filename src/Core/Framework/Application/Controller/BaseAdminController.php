<?php

namespace Core\Framework\Application\Controller;

use Core\Framework\Application\Template\Template;

abstract class BaseAdminController
{
    private Template $template;
    protected string $base_template = 'admin/template.html.twig';

    protected function initTemplate(): void
    {
        $this->template = new Template($this->base_template);
    }

    public function isNeedAuth(): bool
    {
        return true;
    }

    public function actionIndex()
    {
        echo "index";
    }

    public function actionShow($page_num = 1)
    {
        echo "show " . $page_num;
    }
}