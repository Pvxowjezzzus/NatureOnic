<?php


namespace app\core;


abstract class Controller
{
    public $view;
    public $route;
    public $model;
    public $acl;
    public function __construct($route)
    {
        $this->route = $route;
        $this->view = new View($route);
        $this->model = $this->LoadModel($route['controller']);
        if(!$this->checkACL()) {
           View::ErrorStatus(403);
        }

    }

    public function LoadModel($name)
    {
        $path = 'app\models\\'.ucfirst($name);
        if(class_exists($path))
            return new $path($this->route);
    }

    public function checkACL()
    {
        $this->acl = require 'app/ACL/'.$this->route['controller'].'.php';
        if($this->isACL('all')) {
            return true;
        }

        return false;
    }

    public function isACL($key)
    {
        return in_array($this->route['action'], $this->acl[$key]);
    }
}