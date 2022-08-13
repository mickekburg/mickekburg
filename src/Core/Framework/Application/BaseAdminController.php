<?php

namespace Core\Framework\Application;

class BaseAdminController
{
    public function actionIndex()
    {
        echo "index";
    }

    public function actionShow($page_num)
    {
        echo "show " . $page_num;
    }
}