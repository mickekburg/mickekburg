<?php

namespace Module\Login;

use Config\TemplateFactory;
use Core\Framework\Controller\BaseAdminController;
use Core\Framework\Template\Dictionary\TemplateRegionDictionary;
use Core\Widget\Form\DTO\FormFieldDTO;
use Core\Widget\Form\View\Form;
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

        $form_login_fieldset = [
            (new FormFieldDTO())
                ->setType(FormFieldDTO::TYPE_TEXT)
                ->setName('login')
                ->setIsRequired(true)
                ->setPlaceholder($this->translator->trans("admin.login.form.your_login"))
                ->setAttrs([
                    'class' => 'form-control',
                ]),
            (new FormFieldDTO())
                ->setType(FormFieldDTO::TYPE_PASSWORD)
                ->setName('password')
                ->setIsRequired(true)
                ->setPlaceholder($this->translator->trans("admin.login.form.your_password"))
                ->setAttrs([
                    'class' => 'form-control',
                ]),
            (new FormFieldDTO())
                ->setType(FormFieldDTO::TYPE_CHECKBOX)
                ->setName('is_remember')
                ->setAttrs([
                    'id' => 'field_remember',
                ]),
        ];
        if (\Application::i()->getRequest()->get('login_url')) {
            $form_login_fieldset[] = (new FormFieldDTO())
                ->setType(FormFieldDTO::TYPE_HIDDEN)
                ->setName('login_url')
                ->setValue(\Application::i()->getRequest()->get('login_url'));
        }
        $form_login = new Form($form_login_fieldset, "/admin/login/login_form.html.twig");

        $form_forgot_password = new Form([
            (new FormFieldDTO())
                ->setType(FormFieldDTO::TYPE_TEXT)
                ->setName('login')
                ->setIsRequired(true)
                ->setPlaceholder($this->translator->trans("admin.login.form.your_login"))
                ->setAttrs([
                    'class' => 'form-control',
                ]),
            (new FormFieldDTO())
                ->setType(FormFieldDTO::TYPE_HIDDEN)
                ->setName('is_remind')
                ->setValue(1),
        ], "/admin/login/forgot_password.html.twig");

        if (\Application::i()->getRequest()->isXmlHttpRequest()) {
            return new JsonResponse([
                'test' => 123,
            ]);
        }

        $this->template->writeRegion(TemplateRegionDictionary::TOP1, $form_login->render());
        $this->template->writeRegion(TemplateRegionDictionary::TOP2, $form_forgot_password->render());
        return $this->template->render();
    }
}