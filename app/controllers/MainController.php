<?php


namespace app\controllers;
use app\core\Controller;
use app\libs\Pagination;

class MainController extends Controller
{
    public $pagination;

    public function pagination()
    {
        $this->pagination = new Pagination($this->route, $this->model->ItemCount($this->route), 9);
    }

    public function indexAction()
    {
        $this->view->render('ООО Натуроник');
    }

    public function stuffAction()
    {
        $this->pagination();
        $this->model->sortby($_GET);
        $vars = [
            'items' => $this->model->showItems($this->route),
            'pagination' => $this->pagination->get(),
            'cat' => $this->route['cat'],
            'dir' => $this->model->direction(),
            'types' => $this->model->types($this->route),
        ];

        $this->view->render($this->model->title($this->route['cat']), $vars);
    }

}