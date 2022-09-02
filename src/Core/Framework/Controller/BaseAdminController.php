<?php

namespace Core\Framework\Controller;

use Core\Framework\Template\Factory\TemplateFactory;
use Core\Framework\Template\Template;

abstract class BaseAdminController
{
    private Template $template;

    protected function initTemplate(): void
    {
        $this->template = TemplateFactory::getTemplate(TemplateFactory::ADMIN);
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