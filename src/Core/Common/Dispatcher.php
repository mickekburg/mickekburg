<?php

namespace Core\Common;

use Core\Common\Command\AbstractInstallCommand;
use Core\Common\Factory\AbstractModuleSettingsFactory;
use Core\Common\Factory\IModuleSettingsFactory;

final class Dispatcher
{
    private static function getModuleObject(string $class_name, string $object_name): ?string
    {
        $object_path = str_replace("\\", "/", $object_name);
        if (file_exists(APP_PATH . "/src/Module/" . $class_name . "/" . $object_path . ".php")) {
            $command_name = "Module\\" . $class_name . "\\" . $object_name;
        } else {
            $command_name = "Core\Common\\" . $object_name;
        }
        if (!class_exists($command_name)) {
            return null;
        }
        return $command_name;
    }

    public static function getInstallCommand(string $class_name): ?AbstractInstallCommand
    {
        $command_name = self::getModuleObject($class_name, "Command\InstallCommand");
        if (empty($command_name)) {
            return null;
        }
        return new $command_name();
    }

    public static function getModuleSettingsFactory(string $class_name): ?AbstractModuleSettingsFactory
    {
        $command_name = self::getModuleObject($class_name, "Factory\ModuleSettingsFactory");
        if (empty($command_name)) {
            return null;
        }
        return new $command_name();
    }

}