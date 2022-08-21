<?php

use Core\Framework\Application\ModuleInfo\DTO\ModuleFieldDTO;

require __DIR__ . '/vendor/autoload.php';
include_once __DIR__ . '/src/Config/Config.php';

Application::i()->run();

if (ENVIRONMENT == 'development') {
    echo "<!--" . Application::i()->getWorkTime() . "-->";
}


$fields = [];
$fields[] = (new ModuleFieldDTO())
    ->setName("name")
    ->setTitle("Текстовое поле")
    ->setType(ModuleFieldDTO::TYPE_TEXT)
    ->setIsRequired(true)
    ->setIsActive(true);
$fields[] = (new ModuleFieldDTO())
    ->setName("url")
    ->setTitle("URL")
    ->setType(ModuleFieldDTO::TYPE_URL)
    ->setIsActive(true);
$fields[] = (new ModuleFieldDTO())
    ->setName("select1")
    ->setTitle("Выпадающий список")
    ->setType(ModuleFieldDTO::TYPE_SELECT)
    ->setValues(["Не выбрано", "Первый пункт", "Второй пункт"])
    ->setIsActive(true);


/*$repository = new StabAdminTableRepository();
echo (new AdminTable($repository->getColumns(), $repository->getRows()))->render();

$test = new Test();
$test->showOne();


$template = $twig->load('index.html');
echo $template->render(['var' => 'variables', 'go' => 'here']);*/