<?php
namespace app\models;
use app\controllers\MainController;
use app\core\Model;
use app\core\View;

class Main extends Model
{
    private array $cats = [ // Категории
        'nuts' => 'Орехи',
        'driedfruits' => 'Сухофрукты',
    ];
   
    private array $review_data = [
        'Имя пользователя', 'Email', 'Ваше сообщение', 'Выбор продукции'
     ];

    public function ItemCount($cat) { // Подсчет товаров

        if(isset($_GET['type'])) 
            $query = $this->db->column("SELECT COUNT(id) FROM products WHERE type = '" . $_GET['type'] . "' ");
        else 
            $query = $this->db->column("SELECT COUNT(id) FROM products WHERE category = '$cat'");
        
        return $query;
    }

    public function title($cat)
    {
        if(!array_key_exists($cat, $this->cats)) {
            View::ErrorStatus(404);
        }
        return $this->cats[$cat];
    }

	public function showItems($route): array // Отображение товаров
	{
        $max = 9;
        $params = [
            'max' => $max,
            'start' => ((($route['page'] ?: 1) - 1) * $max),
            'category'=>$route['cat'],  
        ];
          if(!empty($_GET['type'])) {
              $items = $this->db->row('SELECT * FROM products  WHERE category = :category AND type = "'.$_GET['type'].'" '.$this->sortby($_GET).' LIMIT :start, :max', $params);
          }
          else {
              $items = $this->db->row('SELECT * FROM  products WHERE  category = :category '.$this->sortby($_GET).' LIMIT :start, :max', $params);
          }
        return $items;
	}


    public function sortby($get) { // Сортировка по разным параметрам
        $dir = mb_convert_case($get['dir'], MB_CASE_UPPER);
         if(empty($get['by'] && $dir)) {
             return 'ORDER BY id DESC';
         }
         else
             return 'ORDER BY '.$get['by'].' '.$dir;
    }



    public function direction(): string // Направление
    {
        if(empty($_GET))
            return 'asc';

        if($_GET['dir'] == 'asc')
            return 'desc';
        else
            return 'asc';

    }

    public function types($route)
    {
        $params = [
            'cat' => $route['cat'],
        ];
        return $this->db->query('SELECT * FROM varietes WHERE category = :cat', $params);
    }

    public function get_type($get) {
        $params = [
            'alias' => $get,
        ];
        $type = $this->db->row('SELECT name FROM varietes WHERE alias = :alias', $params);
        foreach($type as $val) {
            return "&laquo;".$val['name']."&raquo;";
        }
        return false;
    }

    public function get_description($route) {
        switch($route['cat']) {

            case 'dried-fruits':
                $desc = "Каталог «Сухофрукты» на сайте «Натуроник»";
                 break;

            case 'nuts':
                $desc = "Каталог «Орехи» на сайте «Натуроник»";
                break;

            default: 
                $desc = 'Каталог товаров компании «Натуроник»';
                break;

        }
        return $desc;
    }
    public function products(){
       return $this->db->row('SELECT name FROM products ORDER BY name');
    }

    public function valid_request($post) {
        $val = array_values($post);
        if(!$this->array_pass($post)) {
            $this->error =  array("all","Все поля пусты");
            return false;
        }
	    $this->cycle_check($post, $val, 0);
        if(!empty($this->valid['invalid'])) {
            $this->error = array(implode(',',$this->valid['invalid']),
                (count($this->valid['invalid']) > 1 ? 'Не заполнены поля: ' : 'Не заполнено поле: ').implode(", ", $this->valid['data']));
            return false;
        }
        $this->cycle_check($post, $val, 1);
        if(!empty($this->valid['invalid'])) {
            $this->error = array(implode(',',$this->valid['invalid']),
                (count($this->valid['invalid']) > 1 ? 'Ошибки в полях: ' : 'Ошибка в поле: ').implode(", ", $this->valid['data']));
            return false;
        }
        return  true;
    }
   
    public function cycle_check($array,$value, $mode): bool
    {
        $input = array_combine(array_keys($array), $this->review_data);
        $val = array_values($array);
        for ($i = 0, $size = count($array); $i < $size; $i++) {
            if (empty($value[$i]) && $mode == 0) {
                array_push($this->valid['invalid'], array_search($this->review_data[$i], $input));
                array_push($this->valid['data'], $this->review_data[$i]);
            }
	        if (!$this->preg_value(array_keys($_POST)[$i], $val[$i]) && $mode == 1) {
		        array_push($this->valid['invalid'], array_search($this->review_data[$i], $input)); // добавление в массив названия полей (прим. "name")
		        array_push($this->valid['data'], $this->review_data[$i]); // добавление анотаций для ошибок (прим. "Имя")
	        }
        }
        return true;
    }


    public function preg_value($data, $value): bool
    {

        $val = trim($value);

        switch ($data) {
            case 'username':
                if(!preg_match("/^(([a-zA-Z ]{3,30})|([а-яА-ЯЁёІіЇї ]{3,30}))$/u",  $val)) {
	                $error = '«Имя» должно состоять из русских или латинских букв от 3 до 30 символов';
                }
               $this->annotation[] = $this->review_data[0]; // Название поля
                break;

            case 'email':
                if(!preg_match("/([a-zA-Z0-9]+@[a-zA-Z0-9]+\.[a-zA-Z0-9])/",$val)) {
                    $error = 'Неправильный формат эл.почты';
                }
	            $this->annotation[] = $this->review_data[1];
	            break;

            case 'message':
                if(iconv_strlen($val) < 25 || iconv_strlen($val) > 1000) {
	                $error = 'Диапазон символов сообщения от 25 до 1000 символов';
                }
                if(empty($val))
                {
                	$str = "Опишите вашу проблему / вопрос";
	                $this->annotation[] = $str;
                }

                else 
	            $this->annotation[] = $this->review_data[2]; // Название поля
                break;

            case 'product':
                if(empty($val)) {
                   $error = 'Вы не выбрали продукт';
                }
                $this->annotation[ ] = $this->review_data[3];
                break;

            default: $error = 'Ошибка проверки';
                break;
        }
	    if(empty($val)) {
	    	array_push($this->annotation, 'empty');
		    return true;
	    }
		if(!empty($error)) {
		    $this->error = $error;
			return false;
		}
	    array_push($this->annotation, 'valid');
        return true;
    }

	public function send_request($post)
	{
		$params =[
			'id'=> null,
			'username'=>$this->pure($post['username'], ENT_QUOTES),
			'email'=>$this->pure($post['email'], ENT_QUOTES),
            'product'=>$this->pure($post['product'], ENT_NOQUOTES),
			'message'=>$this->pure($post['message'], ENT_NOQUOTES),
			'created_at' => date("Y-m-d H:i"),
			'checked' => 0,
		];
		$this->db->query("INSERT INTO requests VALUES (:id,:username, :email, :product, :message, :created_at,:checked)",$params);
		return true;
    }

    public function sendMessage($post) {
        $message = "Добрый день, ".$post['username']." Вы отправили заявку на сайт Натуроник";
        $to = "".$post['email']."";
        $from = "natureonic@yandex.ru";
        $subject = "Заявка на сайте Натуроник";
        $subject = "?utf-8?B?".base64_encode($subject)."?=";
        $headers = "From: $from\r\nReply-to: $from\r\nContent-Type:
        text/plain; charset=utf-8\r\n";
        mail($to, $subject, $message, $headers);
    }

}
?>
