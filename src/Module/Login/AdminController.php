<?php

namespace Module\Login;

use Core\Framework\Application\Controller\BaseAdminController;

class AdminController extends BaseAdminController
{
    public function isNeedAuth(): bool
    {
        return false;
    }

    public function actionIndex()
    {
        return view("auth", [1,2,3])->render();
    }
}