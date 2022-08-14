<?php

use Core\Framework\Application\Application;
use Symfony\Component\Serializer\Encoder\XmlEncoder;

require __DIR__ . '/vendor/autoload.php';
include_once __DIR__ . '/src/Config/Config.php';

Application::i()->run();

if (ENVIRONMENT == 'development') {
    echo "<!--" . Application::i()->getWorkTime() . "-->";
}


/*$repository = new StabAdminTableRepository();
echo (new AdminTable($repository->getColumns(), $repository->getRows()))->render();

$test = new Test();
$test->showOne();


$template = $twig->load('index.html');
echo $template->render(['var' => 'variables', 'go' => 'here']);*/