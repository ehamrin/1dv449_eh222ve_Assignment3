<?php

define('APP_ROOT', getcwd() . DIRECTORY_SEPARATOR);

define('DEBUG', TRUE);

ini_set('display_errors', DEBUG);
error_reporting(E_ALL);

require_once APP_ROOT . 'includes' . DIRECTORY_SEPARATOR . 'functions.php';
session_start();

$parameters = isset($_GET['url']) ? $_GET['url'] : '';
$parameters = explode('/', $parameters);
if(empty($parameters[count($parameters)-1])){
    unset($parameters[count($parameters)-1]);
}

$controllerName = array_shift($parameters);

switch($controllerName){
    case 'api':
        $controller = new \controller\ApiController($parameters);
        break;
    default:
        $controller = new \controller\Application($parameters);
}

$method = array_shift($parameters);

$method = $method ? $method : 'Index';

$view = new \view\HTML_Template();

$output = '';

if(method_exists($controller, $method)){
    $output = $controller->$method();
}

$view->Render($output);
