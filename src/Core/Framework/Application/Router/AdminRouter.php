<?php

namespace Core\Framework\Application\Router;

use Application;
use Core\Framework\Application\Exception\Error404;
use Core\Framework\Application\ModuleInfo\ModuleInfo;

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
     */
    public function runController(): void
    {
        $controller_name = empty($this->uri[0]) ? DEFAULT_ADMIN_CONTROLLER : $this->uri[0];
        /**
         * @var ModuleInfo
         */
        $module_info = Application::i()->getModuleInfo($controller_name);
        $controller = $module_info->getAdminController();
        $action_name = empty($this->uri[1]) ? "actionIndex" : "action".ucfirst($this->uri[1]);
        if(method_exists($controller, $action_name)){
            $params = array_slice($this->uri, 2);
            $controller->$action_name(...$params);
        }
        else{
            throw new Error404();
        }
    }

    public function runError404(): void
    {
        // TODO: Implement runError404() method.
    }
}