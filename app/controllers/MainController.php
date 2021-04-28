<?php


namespace app\controllers;
use app\core\Controller;
use app\libs\Pagination;

class MainController extends Controller
{
    public $pagination;

    public function pagination()
    {
        $this->pagination = new Pagination($this->route, $this->model->ItemCount($this->route), 9, $this->route['page']);
    }

    public function indexAction()
    {
        $vars = [
            'description' => '«АГРИНОВА» - это компания, которая успешно осуществляет продажу орехов,
             овощей и фруктов оптом. Товар, получаемый в указанные сроки главная задача компании."',
        ];
        $this->view->render('Оптовая продажа', $vars);
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
            'type' => $this->model->get_type($_GET['type']),
            'description' => $this->model->get_description($this->route),
        ];

        $this->view->render("Категория &laquo".$this->model->title($this->route['cat'])."&raquo", $vars);
    }

    public function supportAction() {
            if(!empty($_POST)) {

                    if (!empty($_POST['value']) && !$this->model->preg_value($_POST['name'], $_POST['value'])) {
                        http_response_code(400);
                        exit($this->view->form_msg($_POST['name'], 'invalid-input', $this->model->error));
                    }


					elseif(isset($_POST['value']) && $this->model->preg_value($_POST['name'], $_POST['value'])) {
						exit($this->view->form_msg($_POST['name'], $this->model->annotation[1], $this->model->annotation[0]));
					}
                    if (!$this->model->valid_support($_POST) || !empty($this->model->error)) {
                        http_response_code(400);
                        exit($this->view->form_msg($this->model->error[0], 'invalid', $this->model->error[1]));
                    }
	            if(!$this->model->send_report($_POST)) {
		            http_response_code(400);
		            exit($this->view->message('fail', 'Ошибка отправки заявки'));
	            }
                http_response_code(200);
                exit($this->view->message( 'success', "Ваше сообщение будет прочитано.\nОжидайте ответ на почте\n🔒In development🔒"));
            }


    }
}