<?php


namespace app\controllers;
use app\core\Controller;
use app\libs\Pagination;

class MainController extends Controller
{
    public function indexAction()
    {

        $this->view->render('ООО Натуроник');
    }

    public function fruitsAction()
    {
        $pagination = new Pagination($this->route, $this->model->ItemCount($this->route), 9);
        $vars = [
            'fruits' => $this->model->showItems($this->route),
            'pagination' => $pagination->get(),
        ];

        $this->view->render('Фрукты', $vars);
    }
    public function vegiesAction()
    {
        $vars = [
            'vegies' => $this->model->showItems($this->route),
        ];

        $this->view->render('Овощи', $vars);
    }
    public function nutsAction()
    {
        $vars = [
            'nuts' => $this->model->showItems($this->route),
        ];

        $this->view->render('Орехи', $vars);
    }
}