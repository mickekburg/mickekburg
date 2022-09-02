<?php

namespace Module\Login;

use Core\Framework\Controller\BaseAdminController;
use Core\Framework\Template\Dictionary\TemplateRegionDictionary;
use Core\Framework\Template\Factory\TemplateFactory;

class AdminController extends BaseAdminController
{
    protected function initTemplate(): void
    {
        $this->template = TemplateFactory::getTemplate(TemplateFactory::ADMIN_LOGIN);
        $this->template->writeRegion(TemplateRegionDictionary::META_TITLE, "Система администрирования сайта");
    }

    public function isNeedAuth(): bool
    {
        return false;
    }

    public function actionIndex()
    {
        $this->initTemplate();
        return $this->template->render();
    }
}