<?php

define('APP_ROOT', dirname(getcwd()) . DIRECTORY_SEPARATOR);

define('DEBUG', TRUE);

ini_set('display_errors', DEBUG);
error_reporting(E_ALL);

require_once APP_ROOT . 'includes' . DIRECTORY_SEPARATOR . 'functions.php';

$parameters = isset($_GET['url']) ? $_GET['url'] : '';
$parameters = explode('/', $parameters);
if(empty($parameters[count($parameters)-1])){
    unset($parameters[count($parameters)-1]);
}

$controllerName = array_shift($parameters);

$view = new \view\HTML_Template();

switch($controllerName){
    case 'api':
        $controller = new \controller\ApiController();
        break;
    default:
        $controller = new \controller\Application($view);
}

$method = array_shift($parameters);

$method = $method ? $method : 'Index';



$output = '';

if(method_exists($controller, $method)){
    echo $controller->$method($parameters);
}

