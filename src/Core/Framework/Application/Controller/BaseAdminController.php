<?php

namespace Core\Framework\Application\Controller;

class BaseAdminController
{
    public function actionIndex()
    {
        echo "index";
    }

    public function actionShow($page_num = 1)
    {
        echo "show " . $page_num;
    }
}