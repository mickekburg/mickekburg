<?php

namespace Core\Framework\Controller;

use Config\TemplateFactory;
use Core\Framework\Template\Template;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Translation\Translator;

abstract class BaseAdminController
{
    protected Template $template;
    protected Translator $translator;
    protected EntityManager $db;

    protected function initTemplate(): void
    {
        $this->template = TemplateFactory::getTemplate(TemplateFactory::ADMIN);
        $this->translator = \Application::i()->getTranslator();
        $this->db = \Application::i()->getDbManager();
    }

    public function isNeedAuth(): bool
    {
        return true;
    }

    public function actionIndex()
    {

    }
}