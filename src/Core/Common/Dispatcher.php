<?php

namespace Core\Common;

use Core\Common\Command\AbstractInstallCommand;

final class Dispatcher
{
    private static function getModuleObject(string $class_name, string $object_name)
    {
        $object_path = str_replace("\\", "/", $object_name);
        if (file_exists(APP_PATH . "/src/Module/" . $class_name . "/" . $object_path)) {
            $command_name = "Module\\" . $class_name . "\\" . $object_name;
        } else {
            $command_name = "Core\Common\\" . $object_name;
        }
        return $command_name;
    }

    public static function getInstallCommand(string $class_name): AbstractInstallCommand
    {
        $command_name = self::getModuleObject($class_name, "Command\InstallCommand");
        return new $command_name();
    }

}