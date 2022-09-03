<?php

namespace Core\Framework\Controller;

use Core\Framework\Template\Factory\TemplateFactory;
use Core\Framework\Template\Template;
use Symfony\Component\Translation\Translator;

abstract class BaseAdminController
{
    protected Template $template;
    protected Translator $translator;

    protected function initTemplate(): void
    {
        $this->template = TemplateFactory::getTemplate(TemplateFactory::ADMIN);
        $this->translator = \Application::i()->getTranslator();
    }

    public function isNeedAuth(): bool
    {
        return true;
    }

    public function actionIndex(){

    }
}