<?php

use Core\Framework\Application\ModuleInfo\DTO\ModuleFieldDTO;
use Core\Framework\Application\ModuleInfo\DTO\ModuleInfoDTO;
use Core\Framework\Application\ModuleInfo\DTO\ModuleInfoTabDTO;

require __DIR__ . '/vendor/autoload.php';
include_once __DIR__ . '/src/Config/Config.php';

//Application::i()->run();

if (ENVIRONMENT == 'development') {
    //echo "<!--" . Application::i()->getWorkTime() . "-->";
}


$test = new ModuleInfoDTO("", "", "", [], [], [], "", []);
$tabs = [
    new ModuleInfoTabDTO("1", [
        new ModuleFieldDTO()
    ]),
    new ModuleInfoTabDTO("2", [4, 3]),
];
$test->setTabs($tabs);
$test->setFieldsTds([1234]);
$test->setModuleName("1111");

$serializer = new \Core\Framework\Application\ModuleInfo\Mapper\PhpDocModuleInfoDTOSerializer();

$xml = $serializer->getSerializer()->serialize($test, 'xml', ['xml_format_output' => true,]);
echo $xml;
$test2 = $serializer->getSerializer()->deserialize($xml, ModuleInfoDTO::class, 'xml');
echo 11;

/*$repository = new StabAdminTableRepository();
echo (new AdminTable($repository->getColumns(), $repository->getRows()))->render();

$test = new Test();
$test->showOne();


$template = $twig->load('index.html');
echo $template->render(['var' => 'variables', 'go' => 'here']);*/