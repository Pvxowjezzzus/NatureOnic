<?php

namespace app\controllers;
use app\core\Controller;
use app\core\View;
use app\libs\Pagination;
use Bulletproof\Image;
use Bulletproof;
class AdminController extends Controller
{
    public $pagination;
    protected $permissions=[];
	public function __construct($route) 
	{
		parent::__construct($route);
		$this->view->layout = 'admin';
        if(!$this->checkPermissions()){
            View::ErrorStatus(403);
        }

	}

    public function pagination($elem) // Постраничная навигация
    {
    	if($elem == 'requests') 
            $this->pagination = new Pagination($this->route, $this->model->RequestsCount('all'), 9, $elem);
        else if($elem == 'products')
            $this->pagination = new Pagination($this->route, $this->model->ItemCount('all'), 10, $elem);

    }

    public function checkPermissions() {
        $this->permissions = require 'app/ACL/permissions.php';
        $check = in_array($this->route['action'], explode(",",$this->model->getPermissions().implode(',',$this->permissions['all'])));
        
        if($check)
        return true; 
        
    }
    
    public function AdminAction() // Главная страница
	{
        $this->model->resetCounter();
        $vars = [
           'items'=>$this->model->ItemCount('all'),
           'lastitem'=>$this->model->lastItemTime(),
           'new'=>$this->model->NewItemsCount(),
        ];
		$this->view->render('Панель администратора', $vars);
	}

	public function signupAction() // Регистрация пользователя
	{
		if (!empty($_POST))
		{
			if(!$this->model->signup($_POST)) {
				http_response_code(400);
				exit($this->view->form_valid($this->model->error[0], http_response_code(400), $this->model->error[1]));
			}
			else {
                $this->model->setRole('user');
				http_response_code(200);
				exit($this->view->message(http_response_code(200), 'Вы успешно зарегистрированы'));
			}
		}

		$this->view->render('Регистрация аккаунта');
	}

	public function authAction() { // Вход в ПУ
		if(!empty($_POST)) {
			$_SESSION['lastactivity'] = time();
			if(!$this->model->AuthValid($_POST))
			{
				http_response_code(400);
				exit($this->view->form_valid($this->model->error[0],http_response_code(400), $this->model->error[1]));
			}
			else {
				http_response_code(200);
				exit(array($this->view->location(http_response_code(200),'admin')));
                
			}
		}

		$this->view->render('Вход в панель администратора');
	}

    public function logoutaction() // Выход из панели администратора
    {
        session_destroy();
        $this->view->redirect('admin/login');
    }
    public function profileAction(){
        foreach($this->model->getUserData('all') as $user){
           $user =  $this->model->getRole($user['username']);
           foreach($user as $us){
                $us = $us['role'];
           }
        }
        $vars = [
            'userdata'=> $this->model->getUserData('self'),
            'userrole'=> $this->model->getUserRole('only-role'),
            'users' => $this->model->getUserData('all'),
            'roles'=>$this->model->getUserRole('all'),
            'role'=>$us,
        ];
   
        $this->view->render('Профиль пользователя '.$_SESSION['username'],$vars);
    }
    public function getDiagramAction() {
        $this->model->ItemCount($cat = null);
        exit($this->view->ItemCount($this->model->product['nuts'],$this->model->product['driedfruits']));
    }

    public function changeEmailAction(){
        if (!empty($_POST)) {
            if(!$this->model->changeEmail($_POST)){
                http_response_code(400);
                $this->view->message(http_response_code(400), $this->model->error);
            }
            else 
                $this->view->message(http_response_code(200), "Email успешно изменен!");

        }
    }

    public function changePasswordAction(){
        if (!empty($_POST)) {
            if(!$this->model->changePassword($_POST)){
                http_response_code(400);
                $this->view->message(http_response_code(400), $this->model->error);
            }
            else 
                $this->view->message(http_response_code(200), "Пароль успешно изменен!");

        }
    }

    public function itemsAction()
    {
        $this->pagination('products');
        // $this->model->Excel();
        $vars = [
            'pagination'=>$this->pagination->get(),
            'items'=>$this->model->Items('all', $this->route),
        ];
        $this->view->render('Продукты',$vars);
    }
    
    public function getExcelAction() {
        $this->model->Excel();
    }

    public function itemAddAction() // Добавление товара
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
            $this->model->addCount();
            $this->view->message('added','Продукт успешно добавлен!');
            
        }
    
        $vars = [
            'cats'=> $this->model->cats,
        ];
        $this->view->render('Добавление продукта', $vars);
    }



    public function itemDeleteAction()
    {
        if(!$this->model->ItemExists($this->route['id'])) {
            View::ErrorStatus(404);
        }
        $this->model->DeleteItem($this->route['id']);
        $this->view->redirect("admin/items?cat=".$this->route['cat']);

    }

    public function itemEditAction()
    {
        if(!$this->model->ItemExists($this->route['id'])) {
            View::ErrorStatus(404);
        }
        if (!empty($_POST)) {
            if(!$this->model->postValid($_POST, 'edit')) {
                http_response_code(400);
                exit($this->view->message(http_response_code(400), $this->model->error));
            }
            
            if(!$this->model->CheckChanges($_POST)) {
                http_response_code(400);
                exit($this->view->message(http_response_code(400), $this->model->error));
            }
            
            if(!$this->model->EditItem($_POST, $this->route)) {
                http_response_code(400);
                exit($this->view->message(http_response_code(400), 'Ошибка отправки запроса!'));
            }
            else
            $this->view->message(http_response_code(200),'Данные продукта обновлены!');
        }
        $vars = [
        'item' => $this->model->Items('single',$this->route),
        'url' => "/admin/items/edit/".$this->route['id'],
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

	public function requestsAction()
	{
        $this->pagination('requests');
		$vars = [
        'pagination'=>$this->pagination->get(),
		'requests'=>$this->model->Requests('all', 'request_messages')
        ];
		$this->view->render("Заявки пользователей",$vars);
    }

}
?>