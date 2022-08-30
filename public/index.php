<?php

require __DIR__ . '/../vendor/autoload.php';
include_once __DIR__ . '/../src/Config/Config.php';

Application::i()->run();

if (ENVIRONMENT == 'development') {
    echo "<!--" . Application::i()->getWorkTime() . "-->";
}