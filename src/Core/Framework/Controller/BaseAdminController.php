<?php

namespace Core\Framework\Controller;

use Config\TemplateFactory;
use Core\Framework\ModuleInfo\ModuleInfo;
use Core\Framework\Template\Template;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Translation\Translator;

abstract class BaseAdminController
{
    protected Template $template;
    protected Translator $translator;
    protected EntityManager $db;
    protected ModuleInfo $module;
    protected string $folder = "";
    protected Session $session;

    protected function initTemplate(): void
    {
        $this->template = TemplateFactory::getTemplate(TemplateFactory::ADMIN);
        $this->translator = \Application::i()->getTranslator();
        $this->db = \Application::i()->getDbManager();
        $this->module = \Application::i()->getCurrentModuleInfo();
        $this->session = \Application::i()->getSession();

        $this->module->loadLanguage($this->translator, $this->session->get('Language', LOCALE));
    }

    public function isNeedAuth(): bool
    {
        return true;
    }

    public function actionIndex()
    {

    }
}