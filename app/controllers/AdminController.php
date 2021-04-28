<?php

namespace app\controllers;
use app\core\Controller;
use app\core\View;
use app\libs\Pagination;

class AdminController extends Controller
{
    public $pagination;

    public function pagination($elem)
    {
        $this->pagination = new Pagination($this->route, $this->model->ItemCount($elem), 10, $elem);
    }
    public function __construct($route)
    {
        parent::__construct($route);
        $this->view->layout = 'admin';
        $this->log = $_SERVER['DOCUMENT_ROOT'].'/app/log/stuff.txt';
        if(date('h:i') > date('h:i',filemtime($this->log)))
            file_put_contents($this->log, null);
    }

    public function authAction()
    {

        if(!empty($_POST)) {
            $_SESSION['lastactivity'] = time();
             if(!$this->model->AuthValid($_POST))
            {
                http_response_code(400);
                exit($this->view->message(http_response_code(400), $this->model->error));
            }
            http_response_code(200);
            exit(array($this->view->location( http_response_code(200),'admin')));
        }

        $this->view->render('Вход в Панель Администратора');
    }

    public function signupAction()
    {
        $this->view->render('Регистрация аккаунта');
    }

    public function adminAction()
    {
        $count = file($this->log);
        $vars = [
            'stuff' =>  sizeof($count),
            'changes' =>    date("F d Y H:i:s.", filemtime($this->log))
        ];
       $this->view->render('Панель Администратора', $vars);
    }

    public function logoutaction()
    {
        session_destroy();
        $this->view->redirect('admin/login');
    }

    public function itemsAction()
    {
        $this->pagination($_GET['cat']);
        $vars = [
            'pagination'=>$this->pagination->get(),
            'title'=>$this->model->items_title($_GET['cat']),
            'items'=>$this->model->Items('all', $_GET['cat'],$this->route),
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
                http_response_code(400);
                exit($this->view->message(http_response_code(400), $this->model->error));
            }

            $id = $this->model->AddItem($_POST);
            if(!$id) {
                http_response_code(400);
                exit($this->view->message(http_response_code(400), 'Ошибка отправки запроса!'));
            }
            $this->view->message('added','Продукт успешно добавлен!');
        }
        $vars = [
            'cats'=> $this->model->cats,
        ];
        $this->view->render('Добавление продукта', $vars);
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
                http_response_code(400);
                exit($this->view->message(http_response_code(400), $this->model->error));
            }

            $id = $this->model->EditItem($_POST, $this->route);
            if(!$id) {
                http_response_code(400);
                exit($this->view->message(http_response_code(400), 'Ошибка отправки запроса!'));
            }
            $this->view->message(http_response_code(200),'Данные продукта обновлены!');
//          $this->view->redirect($this->route['cat'].'/'.$this->route['id']);
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
                http_response_code(400);
                exit($this->view->message(http_response_code(400), $this->model->error));
            }
            $id = $this->model->AddType($_POST);
            if(!$id) {
                http_response_code(400);
                exit($this->view->message(http_response_code(400), 'Ошибка отправки запроса!'));
            }
            http_response_code(200);
            $this->view->message(http_response_code(200),'Фильтр успешно добавлен!');
        }
        $vars = [
            'cats'=> $this->model->cats,
        ];
        $this->view->render("Добавление фильтра", $vars);
    }

	public function supportAction()
	{
		$this->pagination('support_messages');
		$vars = ['pagination'=>$this->pagination->get(),
		'items'=>$this->model->Items('all', 'support_messages', null)];
		$this->view->render("Сообщения обратной связи", $vars);
    }

}