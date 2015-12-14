<?php


namespace controller;


class ApiController
{
    public static $cacheDir = APP_ROOT . 'cache' . DIRECTORY_SEPARATOR;

    public function Index(){
        return 'hej';
    }
}