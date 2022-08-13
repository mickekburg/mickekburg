<?php

use Core\Framework\Application\Application;

require __DIR__ . '/vendor/autoload.php';
include_once __DIR__ . '/src/Config/Config.php';

Application::i()->run();


/*$repository = new StabAdminTableRepository();
echo (new AdminTable($repository->getColumns(), $repository->getRows()))->render();

$test = new Test();
$test->showOne();


$template = $twig->load('index.html');
echo $template->render(['var' => 'variables', 'go' => 'here']);*/