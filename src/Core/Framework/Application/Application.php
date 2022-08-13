<?php

namespace Core\Framework\Application;

use Core\Framework\Application\Exception\Error404;
use Core\Framework\Application\Router\RouterFactory;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class Application
{
    private static $instance;
    private static $router;
    private static \Twig\Environment $twig;
    private static $time = 0;
    private static ContainerBuilder $di_container;
    private static Request $request;
    private static array $modules = [];

    public static function i()
    {
        if (self::$instance === null) {
            self::$time = time();
            self::$instance = new static();
        }
        return self::$instance;
    }

    public function getFromDIContainer($service)
    {
        return self::$di_container->get($service);
    }

    public function getRequest(): Request
    {
        return self::$request;
    }

    public function getTwig(): \Twig\Environment
    {
        return self::$twig;
    }

    public function getModuleInfo(string $module_name): ?BaseAdminController
    {
        $class_name = MODULE_PREFIX . "\\" . ucfirst($module_name) . "\\AdminController";
        return self::$modules[ucfirst($module_name)] ? new $class_name() : null;
    }

    public function run()
    {
        self::$di_container = new ContainerBuilder();
        $loader = new XmlFileLoader(self::$di_container, new FileLocator(DI_PATH));
        try {
            $loader->load("Services.xml");
        } catch (\Exception $exception) {
            exit("Services.xml not found");
        }

        $twig_loader = new \Twig\Loader\FilesystemLoader(TEMPLATE_PATH);
        self::$twig = new \Twig\Environment($twig_loader, [
            'cache' => TEMPLATE_CACHE,
            'auto_reload' => TEMPLATE_RELOAD,
        ]);

        $this->initModules();

        $session = new Session();
        $session->start();

        self::$request = Request::createFromGlobals();
        self::$router = RouterFactory::factory(self::$request);

        try {
            self::$router->runController();
        } catch (Error404 $exception) {
            self::$router->runError404();
        }
    }

    private function initModules()
    {
        $finder = new Finder();
        $finder->directories()->in(MODULE_PATH)->depth('== 0');
        if ($finder->hasResults()) {
            foreach ($finder as $module_directory) {
                self::$modules[$module_directory->getRelativePathname()] = $module_directory->getRealPath();
            }
        }
    }
}