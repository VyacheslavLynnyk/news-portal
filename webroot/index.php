<?php
session_start();

define('DS', DIRECTORY_SEPARATOR);

define('ROOT', dirname(dirname(__FILE__)));

define('WEBROOT', $_SERVER['SERVER_NAME'].str_replace('/webroot/index.php', '', $_SERVER['SCRIPT_NAME']));

define('REL_URL', str_replace('/webroot/index.php', '', $_SERVER['SCRIPT_NAME']));

define('VIEW_PATH', ROOT.DS. 'views');

require_once ROOT . DS . 'lib' . DS . 'init.php';

App::run($_SERVER['REQUEST_URI']);
