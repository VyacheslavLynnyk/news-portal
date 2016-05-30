<?php

function mvc_autoload($class_name)
{
    $class_name = strtolower($class_name);
    $lib_path = ROOT . DS . 'lib' . DS . $class_name . '.class.php';
    $controller_path = ROOT . DS . 'controllers' . DS . str_replace('controller', '.controller', $class_name) . '.php';
    $models_path = ROOT . DS . 'models' . DS . $class_name . '.model.php';

    if (file_exists($lib_path)) {
        require_once $lib_path;
    } elseif (file_exists($controller_path)) {
        require_once $controller_path;
    } elseif (file_exists($models_path)) {
        require_once $models_path;
    } else {
        var_dump($class_name);
        Throw NEW Exception('Error! Page ' . $class_name . ' not found!');
    }
}

spl_autoload_register('mvc_autoload');

require_once ROOT . DS . 'vendor' . DS . 'autoload.php';

require_once(ROOT.DS.'configs'.DS.'config.php');