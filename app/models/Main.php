<?php


namespace app\models;
use app\controllers\MainController;
use app\core\Model;
use app\core\View;

class Main extends Model
{
    private array $cats = [
        'fruits'=> 'Фрукты',
        'vegies' => 'Овощи',
        'nuts' => 'Орехи',
        'berries' => 'Ягоды',
        'shrooms' => 'Грибы',
        'meat' => 'Мясная продукция',
    ];
    private array $review_data = [
       'Имя', 'Email', 'Ваше сообщение',
    ];
    private array $valid = [
        'invalid'=> [],
        'data' => [],
    ];
    public function ItemCount($route) {

        if(isset($_GET['type'])) {
        
            $query = $this->db->column("SELECT COUNT(id) FROM " . $route['cat'] . " WHERE type = '" . $_GET['type'] . "' ");
        }
        else {
            $query = $this->db->column("SELECT COUNT(id) FROM " . $route['cat'] . " ");
        }
        return $query;
    }

    public function title($cat)
    {
        if(!array_key_exists($cat, $this->cats)) {
            View::ErrorStatus(404);
        }
        return $this->cats[$cat];
    }

    public function showItems($route)
    {
        $max = 9;
        $params = [
            'max' => $max,
            'start' => ((($route['page'] ?: 1) - 1) * $max),
        ];
          if(!empty($_GET['type'])) {
              $items = $this->db->row('SELECT * FROM '.$route['cat'] .'  WHERE type = "'.$_GET['type'].'" '.$this->sortby($_GET).' LIMIT :start, :max', $params);
          }
          else {
              $items = $this->db->row('SELECT * FROM ' . $route['cat'].' '.$this->sortby($_GET).' LIMIT :start, :max', $params);
          }
            foreach ($items as &$val) {
              $val['country'] = mb_convert_case($val['country'], MB_CASE_TITLE);
            }
            return $items;
    }
    public function sortby($get) {
        $dir = mb_convert_case($get['dir'], MB_CASE_UPPER);
         if(empty($get['by'] && $dir)) {
             return 'ORDER BY id DESC';
         }
         else
             return 'ORDER BY '.$get['by'].' '.$dir;
    }



    public function direction(): string
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
        return $this->db->query('SELECT * FROM varietes WHERE category = :cat ', $params);
    }

    public function get_type($get) {
        $params = [
            'alias' => $get,
        ];
        $type = $this->db->row('SELECT name FROM varietes WHERE alias = :alias ', $params);
        foreach($type as $val) {
            return "&laquo;".$val['name']."&raquo;";
        }
    }

    public function get_description($route) {
        switch($route['cat']) {
            case 'vegies':
                $desc = "Категория «Овощи» на сайте «АГРИНОВА»";
                break;
            
            case 'fruits':
                $desc = "Категория «Фрукты» на сайте «АГРИНОВА»";
                 break;

            case 'nuts':
                $desc = "Категория «Орехи» на сайте «АГРИНОВА»";
                break;


            case 'meat':
                $desc = "Категория «Мясная продукция» на сайте «АГРИНОВА»";
                break;
            
            default: 
                $desc = 'Каталог товаров компании «АГРИНОВА»';
                break;

        }
        return $desc;
    }

    public function valid_support($post) {
        $val = array_values($post);
        if(!$this->array_pass($post)) {
            $this->error =  array("all","Все поля пусты");
            return false;
        }
	    $this->cycle_check($post, $val, 0);
        if(!empty($this->valid['invalid'])) {
            $this->error = array(implode(',',$this->valid['invalid']),
                (array_count_values($this->valid['invalid']) > 1 ? 'Не заполнены поля: ' : 'Не заполнено поле: ').implode(", ", $this->valid['data']));
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
                if(!preg_match("/^(([a-zA-Z ]{5,30})|([а-яА-ЯЁёІіЇї ]{5,30}))$/u",  $val)) {
	                $this->error = '«Имя» должно состоять из русских или латинских букв от 5 до 30 символов';
                }
               $this->annotation[] = $this->review_data[0]; // Название поля
                break;

            case 'email':
                if(!preg_match("/([a-zA-Z0-9]+@[a-zA-Z0-9]+\.[a-zA-Z0-9])/",$val)) {
                    $this->error = 'Неправильный формат эл.почты';
                }
	            $this->annotation[] = $this->review_data[1];
	            break;

            case 'message':
                if(iconv_strlen($val) < 25 || iconv_strlen($val) > 1000) {
	                $this->error = 'Диапазон символов сообщения от 25 до 1000 символов';
                }
                if(empty($val))
                {
                	$str = "Опишите вашу проблему / вопрос";
	                $this->annotation[] = $str;
                }

                else
	                $this->annotation[] = $this->review_data[2]; // Название поля
                break;

            default: $error = 'Ошибка проверки';
                break;
        }
	    if(empty($val)) {
	    	array_push($this->annotation, 'empty');
		    return true;
	    }
		if(!empty($this->error)) {
			return false;
		}
	    array_push($this->annotation, 'valid');
        return true;
    }

	public function send_report($post)
	{
		$params =[
			'id'=> null,
			'username'=>$this->pure($post['username'], ENT_QUOTES),
			'email'=>$this->pure($post['email'], ENT_QUOTES),
			'message'=>$this->pure($post['message'], ENT_NOQUOTES),
			'created_at' => date("Y-m-d H:i:s"),
			'checked' => 0,
		];
		$this->db->query("INSERT INTO support_messages VALUES (:id,:username, :email, :message, :created_at,:checked)",$params);
		return true;
    }


}
