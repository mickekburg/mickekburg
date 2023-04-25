<?php

namespace Module\Main;

use Core\Framework\Controller\BaseAdminController;
use Core\Framework\Template\Dictionary\TemplateRegionDictionary;

class AdminController extends BaseAdminController
{
    public function actionIndex()
    {
        $this->initTemplate();
        $this->template->writeRegion(TemplateRegionDictionary::META_TITLE, $this->translator->trans("admin." . $this->module->getModuleName() . ".meta_title"), true);
        $this->template->writeRegion(TemplateRegionDictionary::CONTENT, 1);
        return $this->template->render();
    }
}