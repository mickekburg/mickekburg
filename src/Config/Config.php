<?php
date_default_timezone_set('Asia/Yekaterinburg');
const ENVIRONMENT = 'development';
const DEFAULT_ADMIN_CONTROLLER = 'main';

define('APP_PATH', $_SERVER['DOCUMENT_ROOT']);
const ADMIN_PATH = "admin";
const TEMPLATE_PATH = APP_PATH . "/templates";
const IS_REDIS = false;

switch (ENVIRONMENT) {
    case 'development':
        error_reporting(E_ALL);
        define('TEMPLATE_RELOAD', true);
        break;
    case 'production':
        error_reporting(0);
        define('TEMPLATE_RELOAD', false);
        break;
}

