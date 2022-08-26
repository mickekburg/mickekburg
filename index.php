<?php

use Core\Framework\Application\ModuleInfo\DTO\ModuleFieldDTO;
use Core\Framework\Application\ModuleInfo\DTO\ModuleInfoDTO;
use Core\Framework\Application\ModuleInfo\DTO\ModuleInfoTabDTO;
use Core\Framework\Application\ModuleInfo\DTO\ModuleTableTdDTO;

require __DIR__ . '/vendor/autoload.php';
include_once __DIR__ . '/src/Config/Config.php';

Application::i()->run();

if (ENVIRONMENT == 'development') {
    echo "<!--" . Application::i()->getWorkTime() . "-->";
}

$tabs = [];
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
$fields[] = (new ModuleFieldDTO())
    ->setName("select2")
    ->setTitle("Список с поиском")
    ->setType(ModuleFieldDTO::TYPE_SELECT)
    ->setMethod(ModuleFieldDTO::METHOD_SEARCH);
$fields[] = (new ModuleFieldDTO())
    ->setName("select3")
    ->setTitle("Список с тегами")
    ->setType(ModuleFieldDTO::TYPE_SELECT)
    ->setMethod(ModuleFieldDTO::METHOD_TAGS);
$fields[] = (new ModuleFieldDTO())
    ->setName("select4")
    ->setTitle("Выпадающий список 4")
    ->setType(ModuleFieldDTO::TYPE_SELECT)
    ->setMethod(ModuleFieldDTO::METHOD_FUNCTION);
$fields[] = (new ModuleFieldDTO())
    ->setName("checkbox")
    ->setTitle("Галочка")
    ->setType(ModuleFieldDTO::TYPE_CHECKBOX);
$fields[] = (new ModuleFieldDTO())
    ->setName("is_show")
    ->setTitle("Показать")
    ->setType(ModuleFieldDTO::TYPE_YES_NO);
$fields[] = (new ModuleFieldDTO())
    ->setName("order")
    ->setTitle("Порядок")
    ->setType(ModuleFieldDTO::TYPE_TEXT);
$fields[] = (new ModuleFieldDTO())
    ->setName("date")
    ->setTitle("Дата")
    ->setType(ModuleFieldDTO::TYPE_DATE)
    ->setDefaultValue(ModuleFieldDTO::DATE_NOW);
$fields[] = (new ModuleFieldDTO())
    ->setName("datetime")
    ->setTitle("Дата и время")
    ->setType(ModuleFieldDTO::TYPE_DATETIME)
    ->setDefaultValue(ModuleFieldDTO::DATE_NOW);
$fields[] = (new ModuleFieldDTO())
    ->setName("pid")
    ->setTitle("Категории")
    ->setType(ModuleFieldDTO::TYPE_PID);
$fields[] = (new ModuleFieldDTO())
    ->setName("textarea")
    ->setTitle("Текст (многоcтрочный)")
    ->setType(ModuleFieldDTO::TYPE_TEXTAREA);
$fields[] = (new ModuleFieldDTO())
    ->setName("ckeditor")
    ->setTitle("Редактор")
    ->setType(ModuleFieldDTO::TYPE_CKEDITOR)
    ->setIsActive(true);
$tabs[] = (new ModuleInfoTabDTO())
    ->setName('Информация')
    ->setFields($fields);

$fields = [];
$fields[] = (new ModuleFieldDTO())
    ->setName("file")
    ->setTitle("Изображение")
    ->setType(ModuleFieldDTO::TYPE_FILE)
    ->setValues(["png", "jpg", "jpeg", "svg", "gif",])
    ->setDefaultValue("200x150")
    ->setIsActive(true);
$fields[] = (new ModuleFieldDTO())
    ->setName("gallery")
    ->setTitle("Галерея")
    ->setType(ModuleFieldDTO::TYPE_GALLERY)
    ->setValues(["png", "jpg", "jpeg", "svg", "gif",]);
$tabs[] = (new ModuleInfoTabDTO())
    ->setName('Изображения')
    ->setFields($fields);

$fields = [];
$fields[] = (new ModuleFieldDTO())
    ->setName("meta_title")
    ->setTitle("Title")
    ->setType(ModuleFieldDTO::TYPE_TEXT);
$tabs[] = (new ModuleInfoTabDTO())
    ->setName('SEO')
    ->setFields($fields);
$tabs[] = (new ModuleInfoTabDTO())
    ->setName('Характеристики')
    ->setAction('showCustomTab');

$tds = [];
$tds[] = (new ModuleTableTdDTO())
    ->setTitle('Наименование')
    ->setMethod(ModuleTableTdDTO::METHOD_EDIT)
    ->setField('meta_title')
    ->setIsFilter(true)
    ->setOrder(1);

$module = (new ModuleInfoDTO())
    ->setTabs($tabs)
    ->setFieldsTds($tds)
    ->setModuleName("Test")
    ->setLiteralName("Тестовый модуль")
    ->setDefaultOrder("order");




/*$repository = new StabAdminTableRepository();
echo (new AdminTable($repository->getColumns(), $repository->getRows()))->render();

$test = new Test();
$test->showOne();


$template = $twig->load('index.html');
echo $template->render(['var' => 'variables', 'go' => 'here']);*/