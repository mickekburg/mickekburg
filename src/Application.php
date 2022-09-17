<?php

use Config\DBConnectionFactory;
use Core\Common\Factory\AbstractConfigFactory;
use Core\Framework\Exception\Error404;
use Core\Framework\Installer\DTO\InstallModuleDTO;
use Core\Framework\Installer\Installer;
use Core\Framework\ModuleInfo\DTO\ModuleInfoDTO;
use Core\Framework\ModuleInfo\Mapper\iModuleInfoDTOSerializer;
use Core\Framework\ModuleInfo\ModuleInfo;
use Core\Framework\Router\Factory\RouterFactory;
use Core\Framework\Router\Router;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Translation\Loader\YamlFileLoader;
use Symfony\Component\Translation\Translator;
use Symfony\Contracts\Cache\ItemInterface;


class Application
{
    private static $instance;
    private static Router $router;
    private static \Twig\Environment $twig;
    private static float $time = 0;
    private static ContainerBuilder $di_container;
    private static Request $request;
    private static array $modules = [];
    private static Translator $translator;
    private static EntityManager $db_manager;
    private static Session $session;
    private static ModuleInfo $current_module_info;

    public static function i(): self
    {
        if (self::$instance === null) {
            self::$time = microtime(true);
            self::$instance = new static();
        }
        return self::$instance;
    }

    /**
     * @throws Exception
     */
    public function getFromDIContainer($service): ?object
    {
        return self::$di_container->get($service);
    }

    public function getRequest(): Request
    {
        return self::$request;
    }

    public function getSession(): Session
    {
        return self::$session;
    }

    public function getTwig(): \Twig\Environment
    {
        return self::$twig;
    }

    public function getDbManager(): EntityManager
    {
        return self::$db_manager;
    }

    public function getTranslator(): Translator
    {
        return self::$translator;
    }

    public function getWorkTime(): float
    {
        return microtime(true) - self::$time;
    }

    public function getModuleInfo(string $module_name): ?ModuleInfo
    {
        return self::$modules[ucfirst($module_name)] ?? null;
    }

    public function getModules(): array
    {
        return self::$modules;
    }

    public function setCurrentModuleInfo(ModuleInfo $module_info): void
    {
        self::$current_module_info = $module_info;
    }

    public function getCurrentModuleInfo(): ModuleInfo
    {
        return self::$current_module_info;
    }

    private function initWhoops(): void
    {
        if (ENVIRONMENT == 'development') {
            $whoops = new \Whoops\Run;
            $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
            $whoops->register();
        }
    }

    private function initSession(): void
    {
        self::$session = new Session();
        self::$session->start();
    }

    private function initLanguage(): void
    {
        $locale = self::$session->get('Language', LOCALE);
        self::$translator = new Translator($locale);
        self::$translator->addLoader('yaml', new YamlFileLoader());
        self::$translator->addResource('yaml', APP_PATH . '/src/Language/translate.' . $locale . '.yaml', $locale);
    }

    private function initDI(): void
    {
        self::$di_container = new ContainerBuilder();
        $loader = new XmlFileLoader(self::$di_container, new FileLocator(APP_PATH . "/src/Config"));
        try {
            $loader->load("Services.xml");
        } catch (\Exception $exception) {
            exit("Services.xml not found");
        }
    }

    private function initTwig(): void
    {
        $twig_loader = new \Twig\Loader\FilesystemLoader(TEMPLATE_PATH);
        self::$twig = new \Twig\Environment($twig_loader, [
            'cache' => TEMPLATE_PATH . "/cache",
            'auto_reload' => TWIG_DEBUG,
            'debug' => TWIG_DEBUG,
        ]);
        self::$twig->addExtension(new \Symfony\Bridge\Twig\Extension\TranslationExtension(self::$translator));
    }

    private function initRequest(): void
    {
        self::$request = Request::createFromGlobals();
    }

    private function initModules(): void
    {
        if (IS_REDIS) {
            self::$modules = $this->initModulesCache();
        } else {
            self::$modules = $this->initModulesDefault();
        }
    }

    /**
     * @param InstallModuleDTO[] $install
     * @return void
     */
    private function installModules(array $install): array
    {
        $modules = [];
        if (count($install)) {
            $default_install_order = Installer::$default_install;
            foreach ($default_install_order as $module_name) {
                foreach ($install as $i => $module) {
                    if ($module->getModuleName() == $module_name) {
                        $installer = new Installer($module);
                        $installer->install();
                        unset($install[$i]);
                        break;
                    }
                }
            }

            foreach ($install as $i => $module) {
                $installer = new Installer($module);
                $installer->install();
                $modules[$module->getModuleName()] = $installer->getResult();
            }
        }
        return $modules;
    }

    private function initModulesDefault(): array
    {
        $modules = [];

        /**
         * @var iModuleInfoDTOSerializer
         */
        $module_info_serializer = self::getFromDIContainer("module_info_serializer");
        $finder = new Finder();
        $finder->directories()->in(APP_PATH . "/src/Module")->depth('== 0');
        if ($finder->hasResults()) {
            $install = [];
            foreach ($finder as $module_directory) {
                $config_file = $module_directory->getRealPath() . "/Config/Config.xml";

                if (!file_exists($config_file)) {
                    $install[] = new InstallModuleDTO(
                        $config_file,
                        $module_directory->getRealPath() . "/Config/ConfigCreator.php",
                        "Module\\" . $module_directory->getBasename() . "\\Config\ConfigCreator",
                        $module_directory->getRelativePathname()
                    );
                } else {
                    /**
                     * @var ModuleInfoDTO
                     */
                    $module_info_dto = $module_info_serializer->getSerializer()->deserialize(file_get_contents($config_file), ModuleInfoDTO::class, 'xml');
                    $modules[$module_directory->getRelativePathname()] = new ModuleInfo($module_info_dto);
                }
            }

            $modules = array_merge($modules, $this->installModules($install));
        }

        return $modules;
    }

    //TODO: redis кэширование конфига
    private function initModulesCache(): array
    {
        $cache = self::getFromDIContainer("cache");
        return $cache->get('modules_cache', function (ItemInterface $item) {
            $item->expiresAfter(3600);
            return $this->initModulesDefault();
        });
    }

    private function initDB(): void
    {
        try {
            $connection = DBConnectionFactory::getDbConfig();
            $db_config = ORMSetup::createAttributeMetadataConfiguration(
                \Core\Framework\ModuleInfo\Mapper\ModuleInfoArrayToEntityDirMapper::map(self::$modules),
                ENVIRONMENT == 'development',
                null,
                null,
                false
            );
            self::$db_manager = EntityManager::create($connection, $db_config);
        } catch (\Exception $exception) {
            exit("DBConnectionFactory config problem");
        } catch (\Doctrine\ORM\Exception\ManagerException $e) {
            exit($e->getMessage());
        }
    }

    public function run(): void
    {
        $this->initWhoops();
        $this->initSession();
        $this->initLanguage();
        $this->initDI();
        $this->initTwig();
        $this->initRequest();
        $this->initModules();
        $this->initDB();

        self::$router = RouterFactory::factory(self::$request);
        try {
            self::$router->runController();
        } catch (Error404 $exception) {
            self::$router->runError404();
        }
    }


}