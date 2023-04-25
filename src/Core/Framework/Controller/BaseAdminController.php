<?php

namespace Core\Framework\Controller;

use Config\TemplateFactory;
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
use Module\Access\Service\AccessService;
use Module\User\Entity\User;
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

    }

    private function loadLeftMenu(): void
    {
        $menu_items = AccessService::i()->getUserAvailableMenu();

        $this->template->writeRegion(TemplateRegionDictionary::LEFT_MENU, (
        new AdminMenuWidget(AdminMenuWidgetMapper::mapAccessModule($menu_items), $this->user->getIsSuperadmin())
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