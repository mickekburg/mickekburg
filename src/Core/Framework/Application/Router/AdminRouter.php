<?php

namespace Core\Framework\Application\Router;

use Application;
use Core\Framework\Application\Auth\DTO\ActionDTO;
use Core\Framework\Application\Auth\IAuth;
use Core\Framework\Application\Controller\BaseAdminController;
use Core\Framework\Application\Exception\Error404;
use Core\Framework\Application\Helper\UrlHelper;
use Core\Framework\Application\ModuleInfo\ModuleInfo;
use ReflectionMethod;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class AdminRouter implements Router
{
    /**
     * @var string[]
     */
    protected array $uri = [];
    protected IAuth $auth;

    /**
     * @param string[] $uri
     */
    public function __construct(array $uri, IAuth $auth)
    {
        array_shift($uri);
        $this->uri = $uri;
        $this->auth = $auth;
    }

    /**
     * @throws Error404
     * @throws \ReflectionException
     */
    public function runController(): void
    {
        $controller_name = empty($this->uri[0]) ? DEFAULT_ADMIN_CONTROLLER : $this->uri[0];
        /**
         * @var ModuleInfo
         */
        $module_info = Application::i()->getModuleInfo($controller_name);

        /**
         * @var BaseAdminController
         */
        $controller = $module_info->getAdminController();
        if ($controller->isNeedAuth() && !$this->auth->isAuth()) {
            $response = new RedirectResponse(UrlHelper::siteUrl(ADMIN_PATH . '/login') . '?login_url=' . urlencode(\Application::i()->getRequest()->getPathInfo()));
            $response->send();
            return;
        }
        $action_name = empty($this->uri[1]) ? "actionIndex" : "action" . ucfirst($this->uri[1]);
        if (!$this->auth->canAccess($module_info, new ActionDTO($action_name))) {
            throw new Error404();
        }
        if (method_exists($controller, $action_name)) {
            $params = array_slice($this->uri, 2);
            $call = new ReflectionMethod(get_class($controller), $action_name);
            if (count($params) >= $call->getNumberOfRequiredParameters() && count($params) <= $call->getNumberOfParameters()) {
                $html = $call->invokeArgs($controller, $params);
                $response = new Response($html);
                $response->send();
                return;
            }
        }

        throw new Error404();
    }

    public function runError404(): void
    {
        echo "404";
        // TODO: Implement runError404() method.
    }
}