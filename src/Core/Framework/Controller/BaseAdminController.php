<?php

namespace Core\Framework\Controller;

use Config\TemplateFactory;
use Core\Framework\Helper\UrlHelper;
use Core\Framework\ModuleInfo\ModuleInfo;
use Core\Framework\Template\Dictionary\TemplateRegionDictionary;
use Core\Framework\Template\Template;
use Core\Widget\AdminMenu\AdminMenuWidget;
use Core\Widget\AdminMenu\Mapper\AdminMenuWidgetMapper;
use Core\Widget\AdminTopMenu\AdminTopMenuWidget;
use Core\Widget\AdminTopMenu\DTO\AdminTopMenuDTO;
use Core\Widget\AdminUserInfo\AdminUserInfoWidget;
use Core\Widget\AdminUserInfo\Mapper\AdminUserInfoWidgetMapper;
use Doctrine\ORM\EntityManager;
use Module\Access\Entity\AccessModuleRole;
use Module\Access\Service\AccessService;
use Module\Login\Sevice\UserLoginService;
use Module\User\Entity\User;
use Symfony\Component\HttpFoundation\RedirectResponse;
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
    protected User $user;

    protected function initTemplate(): void
    {
        $this->template = TemplateFactory::getTemplate(TemplateFactory::ADMIN);
        $this->translator = \Application::i()->getTranslator();
        $this->db = \Application::i()->getDbManager();
        $this->module = \Application::i()->getCurrentModuleInfo();
        $this->session = \Application::i()->getSession();
        $this->user = \Application::i()->getUser();

        $this->module->loadLanguage($this->translator, $this->session->get('Language', LOCALE));
        $this->loadLeftMenu();
        $this->loadUserInfo();
        $this->loadTopMenu();
    }

    public function isNeedAuth(): bool
    {
        return true;
    }

    public function actionIndex()
    {
        return new RedirectResponse(UrlHelper::siteUrl(ADMIN_PATH . "/" . strtolower(\Application::i()->getCurrentModuleInfo()->getModuleName()) . "/show"));
    }

    public function actionShow(int $page_num = 1)
    {
        $this->initTemplate();
        if (!AccessService::i()->hasPermission($this->module, AccessModuleRole::ACTION_VIEW)) {
            return new RedirectResponse(
                UrlHelper::siteUrl(ADMIN_PATH)
            );
        }
        $this->template->writeRegion(TemplateRegionDictionary::META_TITLE, $this->translator->trans("admin." . $this->module->getModuleName() . ".meta_title"), true);
        $this->template->writeRegion(TemplateRegionDictionary::CONTENT, $page_num);
        return $this->template->render();
    }

    private function loadLeftMenu(): void
    {
        $menu_items = AccessService::i()->getUserAvailableMenu();

        $this->template->writeRegion(TemplateRegionDictionary::LEFT_MENU, (
        new AdminMenuWidget(
            AdminMenuWidgetMapper::mapAccessModule($menu_items, $this->module->getModuleName()),
            $this->session->get(UserLoginService::IS_SUPERADMIN_MODE, false),
            $this->user->getIsSuperadmin())
        )->render()
        );
    }

    private function loadUserInfo(): void
    {
        $this->template->writeRegion(TemplateRegionDictionary::USER_INFO, (
        new AdminUserInfoWidget(AdminUserInfoWidgetMapper::mapUser($this->user))
        )->render()
        );
    }

    /**
     * @return AdminTopMenuDTO[]
     */
    private function getTopMenuLinks(): array
    {
        return [];
    }

    private function loadTopMenu(): void
    {
        $this->template->writeRegion(TemplateRegionDictionary::TOP1, (
        new AdminTopMenuWidget($this->getTopMenuLinks())
        )->render()
        );
    }
}