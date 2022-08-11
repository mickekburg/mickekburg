<?php

use Core\Widget\AdminTable\AdminTable;

require __DIR__ . '/vendor/autoload.php';

echo (new AdminTable())->render();

/*$test = new Test();
$test->showOne();

$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/templates');
$twig = new \Twig\Environment($loader, [
    'cache' => __DIR__ . '/templates/compilation_cache',
    'auto_reload' => true,
]);
$template = $twig->load('index.html');
echo $template->render(['var' => 'variables', 'go' => 'here']);*/