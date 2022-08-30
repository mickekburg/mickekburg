<?php

namespace Module\Login;

use Core\Framework\Application\Controller\BaseAdminController;
use Core\Framework\Application\Template\Template;

class AdminController extends BaseAdminController
{
    protected string $base_template = 'admin/login.html.twig';

    protected function initTemplate(): void
    {
        $this->template = new Template($this->base_template);
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