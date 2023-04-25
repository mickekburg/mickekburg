<?php

namespace Module\Login;

use Config\TemplateFactory;
use Core\Framework\Auth\AdminAuth;
use Core\Framework\Controller\BaseAdminController;
use Core\Framework\Helper\UrlHelper;
use Core\Framework\Template\Dictionary\TemplateRegionDictionary;
use Core\Widget\Form\Form;
use Module\Login\DTO\LoginDataDto;
use Module\Login\Exception\WrongPasswordException;
use Module\Login\Factory\FormLoginFieldsFactory;
use Module\Login\Mapper\FormResultArrayToLoginDataDTOMapper;
use Module\Login\Sevice\UserLoginService;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AdminController extends BaseAdminController
{
    protected function initTemplate(): void
    {
        $this->template = TemplateFactory::getTemplate(TemplateFactory::ADMIN_LOGIN);
        $this->translator = \Application::i()->getTranslator();
        $this->template->writeRegion(TemplateRegionDictionary::META_TITLE, $this->translator->trans("admin.meta_title"));
        $this->db = \Application::i()->getDbManager();
    }

    public function isNeedAuth(): bool
    {
        return false;
    }

    public function actionIndex()
    {
        if (AdminAuth::isAuth()) {
            return new RedirectResponse(UrlHelper::siteUrl(UserLoginService::ADMIN_REDIRECT_DEFAULT_URL));
        }

        $login = \Application::i()->getRequest()->cookies->get(UserLoginService::REMEMBER_LOGIN_COOKIE);
        $password = \Application::i()->getRequest()->cookies->get(UserLoginService::REMEMBER_PASSWORD_COOKIE);
        if (!empty($login) && !empty($password)) {
            $dto = new LoginDataDto($login, $password, true, false);
            $service = new UserLoginService($dto);
            try {
                return new RedirectResponse($service->login());
            } catch (\Exception) {
                //Не удалась авторизация по cookies
            }
        }

        $this->initTemplate();

        $form_login = new Form(
            FormLoginFieldsFactory::FORM_LOGIN,
            FormLoginFieldsFactory::getLoginFields((bool)\Application::i()->getRequest()->get(FormLoginFieldsFactory::FIELD_LOGIN_URL)),
            "/admin/login/login_form.html.twig"
        );

        $form_forgot_password = new Form(
            FormLoginFieldsFactory::FORM_FORGOT_PASSWORD,
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
                        $login_service = new UserLoginService($form_login_data_dto);
                        $response = new JsonResponse([
                            'redirect' => $login_service->login(),
                        ]);
                        if ($form_login_data_dto->getIsRemember()) {
                            $user = $login_service->getUser();
                            $response->headers->setCookie(Cookie::create(UserLoginService::REMEMBER_LOGIN_COOKIE, $user->getLogin()));
                            $response->headers->setCookie(Cookie::create(UserLoginService::REMEMBER_PASSWORD_COOKIE, $user->getPassword()));
                        }
                        return $response;
                    } catch (WrongPasswordException) {
                        return new JsonResponse([
                            'message' => $this->translator->trans("admin.login.wrong_password"),
                        ]);
                    }
                }

            } else if ($form_forgot_password->isSubmitted()) {
                //TODO::Восстановление пароля
                return new JsonResponse([
                    'test' => 345,
                ]);
            }

        }

        $this->template->writeRegion(TemplateRegionDictionary::TOP1, $form_login->render());
        $this->template->writeRegion(TemplateRegionDictionary::TOP2, $form_forgot_password->render());
        return $this->template->render();
    }

    public function actionExit(): RedirectResponse
    {
        return UserLoginService::logout();
    }

    public function actionToggleSuperadmin(): RedirectResponse
    {
        $previous = \Application::i()->getRequest()->headers->get('referer');
        if (empty($previous)) {
            $previous = UrlHelper::siteUrl(ADMIN_PATH);
        }

        if (\Application::i()->getUser()->getIsSuperadmin()) {
            \Application::i()->getSession()->set(
                UserLoginService::IS_SUPERADMIN_MODE, !\Application::i()->getSession()->get(UserLoginService::IS_SUPERADMIN_MODE, true)
            );
        }

        return new RedirectResponse($previous);
    }

}