<?php

namespace Core\Framework\Application\Controller;

abstract class BaseAdminController
{
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