<?php

namespace Module\Main;

use Core\Framework\Controller\BaseAdminController;
use Core\Framework\Template\Dictionary\TemplateRegionDictionary;

class AdminController extends BaseAdminController
{
    public function actionIndex()
    {
        $this->initTemplate();
        $this->template->writeRegion(TemplateRegionDictionary::META_TITLE, $this->translator->trans("admin.main.meta_title"), true);

        return $this->template->render();
    }

}