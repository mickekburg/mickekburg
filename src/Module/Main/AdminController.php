<?php

namespace Module\Main;


use Core\Framework\Controller\BaseAdminController;

class AdminController extends BaseAdminController
{
    public function actionIndex()
    {
        $this->initTemplate();
        echo $this->translator->trans("admin.main.meta_title");
    }

}