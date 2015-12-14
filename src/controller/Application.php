<?php


namespace controller;


use view\ApplicationView;

class Application
{
    private $view;

    public function __construct($html)
    {
        $this->view = new ApplicationView($html);
    }

    public function Index(){
        return $this->view->Render();
    }
}