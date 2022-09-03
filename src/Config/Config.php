<?php
date_default_timezone_set('Asia/Yekaterinburg');
const ENVIRONMENT = 'development';
const DEFAULT_ADMIN_CONTROLLER = 'main';

define('APP_PATH', $_SERVER['DOCUMENT_ROOT']);
const ADMIN_PATH = "admin";
const LOGIN_PATH = "login";
const TEMPLATE_PATH = APP_PATH . "/Templates";
const IS_REDIS = false;
const LOCALE = 'ru_RU';

switch (ENVIRONMENT) {
    case 'development':
        error_reporting(E_ALL);
        define('TWIG_DEBUG', true);
        break;
    case 'production':
        error_reporting(0);
        define('TWIG_DEBUG', false);
        break;
}

