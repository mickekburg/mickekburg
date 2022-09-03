<?php

namespace Module\Login;

use Core\Framework\Controller\BaseAdminController;
use Core\Framework\Template\Dictionary\TemplateRegionDictionary;
use Core\Framework\Template\Factory\TemplateFactory;
use Symfony\Component\HttpFoundation\JsonResponse;

class AdminController extends BaseAdminController
{
    protected function initTemplate(): void
    {
        $this->template = TemplateFactory::getTemplate(TemplateFactory::ADMIN_LOGIN);
        $this->translator = \Application::i()->getTranslator();
        $this->template->writeRegion(TemplateRegionDictionary::META_TITLE, $this->translator->trans("admin.meta_title"));
    }

    public function isNeedAuth(): bool
    {
        return false;
    }

    public function actionIndex()
    {
        $this->initTemplate();
        if (\Application::i()->getRequest()->isXmlHttpRequest()) {
            return new JsonResponse([
                'test'=>123,
            ]);
        }
        return $this->template->render();
    }
}