<?php


namespace app\controllers;
use app\core\Controller;

class MainController extends Controller
{
    public function indexAction()
    {

        $this->view->render('ООО Натуроник');
    }

    public function fruitsAction()
    {
        $vars = [
            'fruits' => $this->model->showItems($this->route),
        ];

        $this->view->render('Фрукты', $vars);
    }
}