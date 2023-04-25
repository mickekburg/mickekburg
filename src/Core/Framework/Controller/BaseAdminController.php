<?php

namespace Core\Framework\Controller;

use Config\TemplateFactory;
use Core\Common\Dispatcher;
use Core\Common\Repository\ICommonRepository;
use Core\Framework\Helper\UrlHelper;
use Core\Framework\ModuleInfo\ModuleInfo;
use Core\Framework\Template\Dictionary\TemplateRegionDictionary;
use Core\Framework\Template\Template;
use Core\Widget\AdminGroupTree\AdminGroupTreeWidget;
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
use Module\User\Factory\ModuleSettingsFactory;
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
    protected ModuleSettingsFactory $module_settings_factory;

    protected function initTemplate(): void
    {
        $this->template = TemplateFactory::getTemplate(TemplateFactory::ADMIN);
        $this->translator = \Application::i()->getTranslator();
        $this->db = \Application::i()->getDbManager();
        $this->module = \Application::i()->getCurrentModuleInfo();
        $this->session = \Application::i()->getSession();
        $this->user = \Application::i()->getUser();
        $this->module_settings_factory = Dispatcher::getModuleSettingsFactory($this->module->getModuleName());

        $this->module->loadLanguage($this->translator, $this->session->get('Language', LOCALE));
        $this->loadLeftMenu();
        $this->loadUserInfo();
        $this->loadTopMenu();
    }

    public function isNeedAuth(): bool
    {
        return true;
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


    /* Actions */

    public function actionIndex()
    {
        return new RedirectResponse(UrlHelper::siteUrl(ADMIN_PATH . "/" . strtolower(\Application::i()->getCurrentModuleInfo()->getModuleName()) . "/show"));
    }

    public function actionShow(?int $parent_id = null, int $page_num = 1)
    {
        $this->initTemplate();
        if (!AccessService::i()->hasPermission($this->module, AccessModuleRole::ACTION_VIEW)) {
            return new RedirectResponse(
                UrlHelper::siteUrl(ADMIN_PATH)
            );
        }
        $this->template->writeRegion(TemplateRegionDictionary::META_TITLE, $this->translator->trans("admin." . $this->module->getModuleName() . ".meta_title"), true);

        $data = [
            'admin_group_tree' => '',
        ];
        if ($this->module->hasGroup()) {
            /**
             * @var ICommonRepository $group_repository
             */
            $group_repository = $this->db->getRepository($this->module_settings_factory->getEntityGroupClass());
            if (!empty($group_repository)) {
                $data['admin_group_tree'] = (new AdminGroupTreeWidget(
                    $group_repository,
                    $parent_id,
                    AccessService::i()->getModulePermissions($this->module)
                ))->render();
            }
        }

        try {
            $twig_template = \Application::i()->getTwig()->load($this->module_settings_factory->getShowTemplate());
            $content = $twig_template->render($data);
            $this->template->writeRegion(TemplateRegionDictionary::CONTENT, $content);
        } catch (\Exception) {
            return "";
        }


        return $this->template->render();
    }


}