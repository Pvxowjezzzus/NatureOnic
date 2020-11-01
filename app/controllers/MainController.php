<?php


namespace app\controllers;
use app\core\Controller;

class MainController extends Controller
{
    public function IndexAction()
    {
        $this->view->render('ООО Натуроник');
    }
}