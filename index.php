<?php

define('APP_PATH', $_SERVER['DOCUMENT_ROOT']);

use Core\Module\AdminTable\Repository\StabAdminTableRepository;
use Core\Module\AdminTable\Widget\AdminTable;

require __DIR__ . '/vendor/autoload.php';

$repository = new StabAdminTableRepository();
echo (new AdminTable($repository->getColumns(), $repository->getRows()))->render();

/*$test = new Test();
$test->showOne();

$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/templates');
$twig = new \Twig\Environment($loader, [
    'cache' => __DIR__ . '/templates/compilation_cache',
    'auto_reload' => true,
]);
$template = $twig->load('index.html');
echo $template->render(['var' => 'variables', 'go' => 'here']);*/