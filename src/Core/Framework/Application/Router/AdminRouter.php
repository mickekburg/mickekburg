<?php

namespace Core\Framework\Application\Router;

use Application;
use Core\Framework\Application\Controller\BaseAdminController;
use Core\Framework\Application\Exception\Error404;
use Core\Framework\Application\ModuleInfo\ModuleInfo;
use ReflectionMethod;

class AdminRouter implements Router
{
    /**
     * @var string[]
     */
    protected array $uri = [];

    /**
     * @param string[] $uri
     */
    public function __construct(array $uri)
    {
        array_shift($uri);
        $this->uri = $uri;
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
        $action_name = empty($this->uri[1]) ? "actionIndex" : "action" . ucfirst($this->uri[1]);
        if (method_exists($controller, $action_name)) {
            $params = array_slice($this->uri, 2);
            $call = new ReflectionMethod(get_class($controller), $action_name);
            if (count($params) >= $call->getNumberOfRequiredParameters() && count($params) <= $call->getNumberOfParameters()) {
                $call->invokeArgs($controller, $params);
            } else {
                throw new Error404();
            }
        } else {
            throw new Error404();
        }
    }

    public function runError404(): void
    {
        echo "404";
        // TODO: Implement runError404() method.
    }
}