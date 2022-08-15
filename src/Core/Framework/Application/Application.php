<?php

namespace Core\Framework\Application;

use Core\Framework\Application\Exception\Error404;
use Core\Framework\Application\ModuleInfo\DTO\ModuleInfoDTO;
use Core\Framework\Application\Router\RouterFactory;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Contracts\Cache\ItemInterface;

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
            self::$time = microtime(true);
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

    public function getWorkTime(): float
    {
        return microtime(true) - self::$time;
    }

    public function getModuleInfo(string $module_name): ?ModuleInfoDTO
    {
        return self::$modules[ucfirst($module_name)] ?? null;
    }

    public function run()
    {
        self::$di_container = new ContainerBuilder();
        $loader = new XmlFileLoader(self::$di_container, new FileLocator(APP_PATH . "/src/Config"));
        try {
            $loader->load("Services.xml");
        } catch (\Exception $exception) {
            exit("Services.xml not found");
        }

        $twig_loader = new \Twig\Loader\FilesystemLoader(TEMPLATE_PATH);
        self::$twig = new \Twig\Environment($twig_loader, [
            'cache' => TEMPLATE_PATH . "/cache",
            'auto_reload' => TEMPLATE_RELOAD,
        ]);

        if (IS_REDIS) {
            self::$modules = $this->initModulesCache();
        } else {
            self::$modules = $this->initModules();
        }

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


    private function initModules(): array
    {
        $encoders = [new XmlEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $modules = [];
        $finder = new Finder();
        $finder->directories()->in(APP_PATH . "/src/Module")->depth('== 0');
        if ($finder->hasResults()) {
            foreach ($finder as $module_directory) {
                $config_default_file = $module_directory->getRealPath() . "/Config/Config.default.xml";
                $config_file = $module_directory->getRealPath() . "/Config/Config.xml";
                if (file_exists($config_default_file) && !file_exists($config_file)) {
                    copy($config_default_file, $config_file);
                }

                if (file_exists($config_file)) {
                    $module_info = $serializer->deserialize(file_get_contents($config_file), ModuleInfoDTO::class, 'xml');
                    $module_info->init();
                    $modules[$module_directory->getRelativePathname()] = $module_info;
                }
            }
        }

        return $modules;
    }

    //TODO: redis кэширование конфига
    private function initModulesCache(): array
    {
        $cache = self::getFromDIContainer("cache");
        return $cache->get('modules_cache', function (ItemInterface $item) {
            $item->expiresAfter(3600);
            return $this->initModules();
        });
    }
}