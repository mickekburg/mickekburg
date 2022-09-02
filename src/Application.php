<?php

use Core\Framework\Exception\Error404;
use Core\Framework\ModuleInfo\DTO\ModuleInfoDTO;
use Core\Framework\ModuleInfo\Factory\IConfigCreator;
use Core\Framework\ModuleInfo\Mapper\iModuleInfoDTOSerializer;
use Core\Framework\ModuleInfo\ModuleInfo;
use Core\Framework\Router\RouterFactory;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Translation\Loader\YamlFileLoader;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Component\Translation\Translator;


class Application
{
    private static $instance;
    private static $router;
    private static \Twig\Environment $twig;
    private static $time = 0;
    private static ContainerBuilder $di_container;
    private static Request $request;
    private static array $modules = [];
    private static Translator $translator;

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

    public function getModuleInfo(string $module_name): ?ModuleInfo
    {
        return self::$modules[ucfirst($module_name)] ?? null;
    }

    public function run()
    {
        if (ENVIRONMENT == 'development') {
            $whoops = new \Whoops\Run;
            $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
            $whoops->register();
        }

        self::$di_container = new ContainerBuilder();
        $loader = new XmlFileLoader(self::$di_container, new FileLocator(APP_PATH . "/src/Config"));
        try {
            $loader->load("Services.xml");
        } catch (\Exception $exception) {
            exit("Services.xml not found");
        }

        self::$translator = new Translator('ru_Ru');
        self::$translator->addLoader('yaml', new YamlFileLoader());
        self::$translator->addResource('yaml', APP_PATH . '/src/Language/translate.ru.yaml', 'ru_Ru');

        $twig_loader = new \Twig\Loader\FilesystemLoader(TEMPLATE_PATH);
        self::$twig = new \Twig\Environment($twig_loader, [
            'cache' => TEMPLATE_PATH . "/cache",
            'auto_reload' => TEMPLATE_RELOAD,
        ]);
        self::$twig->addExtension(new \Symfony\Bridge\Twig\Extension\TranslationExtension(self::$translator));


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
        $modules = [];

        /**
         * @var iModuleInfoDTOSerializer
         */
        $module_info_serializer = self::getFromDIContainer("module_info_serializer");
        $finder = new Finder();
        $finder->directories()->in(APP_PATH . "/src/Module")->depth('== 0');
        if ($finder->hasResults()) {
            foreach ($finder as $module_directory) {
                $config_file = $module_directory->getRealPath() . "/Config/Config.xml";

                if (!file_exists($config_file)) {
                    $config_creator_file = $module_directory->getRealPath() . "/Config/ConfigCreator.php";
                    if (file_exists($config_creator_file)) {
                        $config_creator_name = "Module\\" . $module_directory->getBasename() . "\\Config\ConfigCreator";
                        $config_creator = new $config_creator_name();
                        if ($config_creator instanceof IConfigCreator) {
                            file_put_contents($config_file, $config_creator->createConfig());
                        }
                    }
                }

                if (file_exists($config_file)) {
                    /**
                     * @var ModuleInfoDTO
                     */
                    $module_info_dto = $module_info_serializer->getSerializer()->deserialize(file_get_contents($config_file), ModuleInfoDTO::class, 'xml');
                    $modules[$module_directory->getRelativePathname()] = new ModuleInfo($module_info_dto);
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