<?php


namespace app\controllers;
use app\core\Controller;
use app\libs\Pagination;

class MainController extends Controller
{
    public $pagination;

    public function pagination() // Постраничная навигация
    {
        $this->pagination = new Pagination($this->route, $this->model->ItemCount($this->route['cat']), 9, $this->route['page']);
    }

    public function indexAction() // Главная страница сайта
    {
        
        $vars = [
            "products"=>$this->model->products(),
        ];
        $this->view->render('Сайт',$vars);
    }

    public function stuffAction() // Страница товаров
    {
        $this->pagination();
        $this->model->sortby($_GET);
        $vars = [
            'items' => $this->model->showItems($this->route), // Демонстрация товаров
            'pagination' => $this->pagination->get(), // Постраничная навигация
            'cat' => $this->route['cat'], // Категория товара
            'dir' => $this->model->direction(), // Сортировка по возрастанию или убыванию
            'types' => $this->model->types($this->route), // Фильтры
            'type' => $this->model->get_type($_GET['type']), // Тип
            'description' => $this->model->get_description($this->route), // Описание товара
        ];

        $this->view->render("Каталог ".$this->model->title($this->route['cat'])."", $vars);
    }

    public function requestAction() { // Страница заявки
        if(!empty($_POST)) {

            if (!empty($_POST['value']) && !$this->model->preg_value($_POST['name'], $_POST['value'])) {
                http_response_code(400);
                exit($this->view->form_valid($_POST['name'], 'invalid-input', $this->model->error));
            }


            elseif(isset($_POST['value']) && $this->model->preg_value($_POST['name'], $_POST['value'])) {
                exit($this->view->form_valid($_POST['name'], $this->model->annotation[1], $this->model->annotation[0]));
            }
            if (!$this->model->valid_request($_POST) || !empty($this->model->error)) {
                http_response_code(400);
                exit($this->view->form_valid($this->model->error[0], 'invalid', $this->model->error[1]));
            }
        if(!$this->model->send_request($_POST)) {
            http_response_code(400);
            exit($this->view->message('fail', 'Ошибка отправки заявки'));
        }
        else {
            http_response_code(200);
            $this->model->sendMessage($_POST);
            exit($this->view->message('success', "Ваше сообщение будет прочитано.\n"));
        }
    }


    }
}
?>