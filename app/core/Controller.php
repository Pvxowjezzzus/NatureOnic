<?php


namespace app\core;


abstract class Controller
{
    public $view;
    public $route;
    public $model;
    protected $acl = [];
    public function __construct($route)
    {
        $this->route = $route;
        $this->model = $this->LoadModel($route['controller']);
        if(!$this->checkACL()) {
            View::ErrorStatus(403);
        }
        $this->view = new View($route);


    }

    public function LoadModel($name)
    {
        $path = 'app\models\\'.ucfirst($name);
        if(class_exists($path))
            return new $path($this->route);
    }

    public function checkACL()
    {
        $this->acl = require 'app/ACL/acl.php';
        if ($this->isAcl('all')) {
            return true;
        }
        elseif ($this->isACL('login/admin') && $this->model->ipList() && !isset($_SESSION['admin'])) {
            return true;
        }
        elseif ($this->isACL('admin') && $this->model->ipList() && isset($_SESSION['admin'])) {
            return true;
        }


        return false;
    }

    public function isACL($key)
    {
        return in_array($this->route['action'], $this->acl[$key], true);
    }
}