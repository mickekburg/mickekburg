<?php

use Symfony\Component\Finder\Finder;

include_once __DIR__ . '/../../vendor/autoload.php';
include_once __DIR__ . '/../Config/Config.php';

$uninstall = [];
if (count($argv) > 1) {
    array_shift($argv);
    $uninstall = $argv;
}

$finder = new Finder();
$finder->directories()->in(__DIR__ . "/../Module")->depth('== 0');
if ($finder->hasResults()) {
    $install = [];
    foreach ($finder as $module_directory) {
        $config_file = $module_directory->getRealPath() . "/Config/Config.xml";

        if (file_exists($config_file) && (empty($uninstall) || in_array($module_directory->getBasename(), $uninstall))) {
            unlink($config_file);
        }
    }
}