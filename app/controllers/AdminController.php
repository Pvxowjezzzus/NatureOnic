<?php

namespace app\controllers;
use app\core\Controller;
use app\core\View;

class AdminController extends Controller
{
    public function __construct($route)
    {
        parent::__construct($route);
        $this->view->layout = 'admin';
    }

    public function authAction()
    {

        if(!empty($_POST)) {
            $_SESSION['lastactivity'] = time();
             if(!$this->model->AuthValid($_POST))
            {
                exit($this->view->message(http_response_code(400), $this->model->error));
            }

            exit($this->view->location('admin-panel'));
        }

        $this->view->render('Вход в Панель Администратора');
    }

    public function adminAction()
    {
       $this->view->render('Панель Администратора');
    }

    public function logoutaction()
    {

        session_destroy();
        $this->view->redirect('admin/login');
    }

    public function itemsAction()
    {
        $vars = [
            'title'=>$this->model->items_title($_GET),
            'items'=>$this->model->Items('all',''),
        ];
        $this->view->render('Продукты',$vars);
    }

    public function itemAddAction()
    {
        if(!empty($_GET)) {
            $this->model->types($_GET);
        }

        if (!empty($_POST)) {
            if(!$this->model->postValid($_POST, 'add')) {

                exit($this->view->message(http_response_code(400), $this->model->error));
            }

            $id = $this->model->AddItem($_POST);
            if(!$id) {
                exit($this->view->message(http_response_code(400), 'Ошибка отправки запроса!'));
            }
            $this->view->message('added','Продукт успешно добавлен!');
        }
        $this->view->render('Добавление продукта');
    }


    public function itemDeleteAction()
    {
        if(!$this->model->ItemExists($this->route['cat'], $this->route['id'])) {
            View::ErrorStatus(404);
        }
        $this->model->DeleteItem($this->route['cat'], $this->route['id']);
        $this->view->redirect("admin/items?cat=".$this->route['cat']);

    }

    public function itemEditAction()
    {
        if(!$this->model->ItemExists($this->route['cat'], $this->route['id'])) {
            View::ErrorStatus(404);
        }
        if (!empty($_POST)) {
            if(!$this->model->postValid($_POST, 'edit')) {

                exit($this->view->message(http_response_code(400), $this->model->error));
            }

            $id = $this->model->EditItem($_POST, $this->route);
            if(!$id) {
                exit($this->view->message(http_response_code(400), 'Ошибка отправки запроса!'));
            }
            $this->view->message(http_response_code(200),'Данные продукта обновлены!');
        }
        $vars = [
        'item' => $this->model->Items('single',$this->route),
        'url' => "/admin/items/edit/".$this->route['cat']."/".$this->route['id'],
        'cat' => $this->route['cat'],
    ];
        $this->view->render("Редактирование", $vars);
    }

    public function typeAddAction()
    {
        if (!empty($_POST)) {
            if (!$this->model->typeValid($_POST)) {

                exit($this->view->message(http_response_code(400), $this->model->error));
            }
            $id = $this->model->AddType($_POST);
            if(!$id) {
                exit($this->view->message(http_response_code(400), 'Ошибка отправки запроса!'));
            }
            $this->view->message(http_response_code(200),'Фильтр успешно добавлен!');
        }
        $this->view->render("Добавление фильтра");
    }

}