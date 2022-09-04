<?php

namespace Module\Login;

use Config\TemplateFactory;
use Core\Framework\Controller\BaseAdminController;
use Core\Framework\Helper\UrlHelper;
use Core\Framework\Template\Dictionary\TemplateRegionDictionary;
use Core\Widget\Form\DTO\FormFieldDTO;
use Core\Widget\Form\Form;
use Module\Login\DTO\LoginDataDto;
use Module\Login\Factory\FormLoginFieldsFactory;
use Module\Login\Mapper\FormResultArrayToLoginDataDTOMapper;
use Module\Login\Sevice\UserLoginService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;

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
        $remember_data = $this->getRememberData();
        if (!empty($remember_data)) {
            try {
                (new UserLoginService($remember_data))->login();
                return (new RedirectResponse(UrlHelper::siteUrl('/')));
            } catch (\Exception) {
                //Не удалась авторизация по cookies
            }
        }

        $this->initTemplate();

        $form_login = new Form(
            FormLoginFieldsFactory::FORM_LOGIN,
            FormLoginFieldsFactory::getLoginFields(\Application::i()->getRequest()->get('login_url')),
            "/admin/login/login_form.html.twig"
        );

        $form_forgot_password = new Form(
            'form_forgot_password',
            FormLoginFieldsFactory::getForgotPasswordFields(),
            "/admin/login/forgot_password.html.twig"
        );

        if (\Application::i()->getRequest()->isXmlHttpRequest()) {
            if ($form_login->isSubmitted()) {
                $is_valid = $form_login->process();
                if ($is_valid) {
                    $form_login_result = $form_login->getResult();
                    try {
                        $form_login_data_dto = FormResultArrayToLoginDataDTOMapper::map($form_login_result);
                        (new UserLoginService($form_login_data_dto))->login();
                        return (new RedirectResponse(UrlHelper::siteUrl('/')));
                    } catch (\Exception) {
                        //Не удалась авторизация по cookies
                    }
                }
                return new JsonResponse([
                    'test' => 123,
                ]);
            } else if ($form_forgot_password->isSubmitted()) {
                return new JsonResponse([
                    'test' => 345,
                ]);
            }

        }

        $this->template->writeRegion(TemplateRegionDictionary::TOP1, $form_login->render());
        $this->template->writeRegion(TemplateRegionDictionary::TOP2, $form_forgot_password->render());
        return $this->template->render();
    }

    private function getRememberData(): ?LoginDataDto
    {
        $login = \Application::i()->getRequest()->cookies->get('remember_login');
        $password = \Application::i()->getRequest()->cookies->get('remember_password');
        if (!empty($login) && !empty($password)) {
            return new LoginDataDto($login, $password, true, false);
        }
        return null;
    }
}