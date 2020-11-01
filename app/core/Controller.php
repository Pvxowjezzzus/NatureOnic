<?php


namespace app\core;

use app\core\View;

abstract class Controller
{
    public $view;
    public $route;
    public function __construct($route)
    {
        $this->route = $route;
        $this->view = new View($route);
    }
}