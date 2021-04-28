<?php


namespace app\models;


use app\core\Model;
use app\core\Controller;
use app\core\View;
use app\libs\Images;

class Admin extends Model
{
    public $data;
    public $cats = [
        'fruits' => 'Фрукты',
        'vegies' => 'Овощи',
        'nuts' => 'Орехи',
        'berries' => 'Ягоды',
        'shrooms' => 'Грибы',
        'meat' => 'Мясная продукция',
    ];

    public function ipList(): bool
    {
        $white_list = array(
            '188.123.231',
            '176.59.53',
            '127.0.0',
        );
        $ip = explode('.',$_SERVER['REMOTE_ADDR']);
	    $ip = $ip[0].".".$ip[1].".".$ip[2];
	    foreach($white_list as $value) {
		    if( $ip == $value)
			    return true;
	    }
        return false;
    }

    public function AuthValid($post)
    {

        if (empty($post['login'] and $post['password'])) {
            $this->error = 'Заполните все поля!';
            return false;
        }
        $params = [
            'login' => $post['login'],
            'password' => $post['password'],
        ];
        $query = $this->db->column('SELECT login FROM users WHERE   login = :login AND password = :password OR email = :login AND  password = :password', $params);
        if (!$query) {
            $this->error = "Ошибка аутентификации\n 'Логин' или 'Пароль' неправильный";
            return false;
        }
        $_SESSION['admin'] = 1;
        $_SESSION['login'] = $query;
        $this->data = $query;
        return true;
    }

    public function types($get)
    {
        $params = [
            'cat' => $get['cat'],
        ];
        $types = $this->db->query('SELECT * FROM varietes WHERE category = :cat ', $params);
        foreach ($types as $type) {
            echo "<option id=" . $type['alias'] . " value=" . $type['alias'] . ">" . $type['name'] . "</option>";
        }
        exit;
    }
    public function ItemCount($get) {

        $query = $this->db->column(" SELECT COUNT(id) FROM ". $get ." ");
        return $query;
    }
    public function postValid($post, $type)
    {
        $namelen = iconv_strlen($post['name']);
        $desclen = iconv_strlen($post['description']);
        if ($type == 'add') {
            if (empty($post['item-cat'])) {
                $this->error = 'Выберите категорию товара.';
                return false;
            }

            if (!array_key_exists($post['item-cat'], $this->cats)) {
                $this->error = 'Ошибка SQL-запроса';
                return false;
            }
            $query = $this->db->column(" SELECT name FROM " . $post['item-cat'] . " WHERE name = '" . $this->pure($post['name'],ENT_HTML5) . "'");
            if ($query) {
                $this->error = 'Название продукта должно быть уникальным!';
                return false;
            }
        }

        if ($namelen < 5 || $namelen > 100) {
            $this->error = 'Поле "Название" должно содержать от 5 до 100 символов';
            return false;
        }

        if ($desclen < 20 || $desclen > 500) {
            $this->error = 'Поле "Описание" должно содержать от 20 до 500 символов';
            return false;
        }
        if (empty($post['country'])) {
            $this->error = 'Поле "Страна-производитель" не заполнено';
            return false;
        }
        if (empty($_FILES['image']['tmp_name']) && $type == 'add') {
            $this->error = 'Изображение не выбрано';
            return false;
        } elseif ($type == 'add') {

            $allowed_types = [IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_JPEG2000, IMAGETYPE_WEBP, IMAGETYPE_BMP, IMAGETYPE_GIF];
            if (array_search(exif_imagetype($_FILES['image']['tmp_name']),$allowed_types)) {
                return true;
            }
                else {
                $this->error = 'Запрещенный тип файла';
                return false;
                }
        }

        return true;
    }

    public function uploadImage($part)
    {
            if(empty(array_column($_FILES['image'], 'error'))) {
                $tmpname = $_FILES['image']['tmp_name'];
                $uploadImage = basename($_FILES['image']['name']);
            }
        
        
        $path = "public_html".$part;
        static $randStr = '0123456789abcdefghijklmnopqrstuvwxyz';
        $randname = '';
        for ($i = 0; $i < 10; $i++) {
            $key = rand(0, strlen($randStr) - 1);
            $randname .= $randStr[$key];
        }
    
        $uploadImageName = trim(strip_tags($uploadImage));
        $extension = pathinfo($uploadImageName, PATHINFO_EXTENSION);
        $file = $randname . '.' . $extension;
        if (!move_uploaded_file($tmpname, "$path$file")) {
            $this->error = 'Ошибка загрузки изображения';
            return false;

        } else
            $size = GetImageSize("$path$file");
        if ($size[0] > 360 || $size[1] > 240) {
            $image = new Images();
            $image->load("$path$file");
            $image->resize(360, 240);
            $image->save("$path$file");
        }
        return "$path$file";
    }

    public function AddItem($post)
    {
        $params = [
            'id' => null,
            'name' => $this->pure($post['name'],ENT_NOQUOTES),
            'type' => $this->pure($post['item-kind'],ENT_NOQUOTES),
            'text' => $this->pure($post['description'],ENT_NOQUOTES),
            'country' => $this->pure($post['country'], ENT_NOQUOTES),
            'images' => $this->uploadImage("/content/images/"),
            'created_at' => date("Y-m-d H:i:s"),
        ];

        $this->db->query("INSERT INTO " . $post['item-cat'] . "  VALUES (:id, :name, :type, :country, :text,:images, :created_at)", $params);
        return true;
    }

    public function EditItem($post, $route)
    {
        $params = [
            'id' => $route['id'],
            'name' => mb_convert_case($this->pure($post['name'], ENT_NOQUOTES), MB_CASE_TITLE),
            'type' => $this->pure($post['item-kind'],ENT_HTML5),
            'text' => mb_convert_case($this->pure($post['description'],ENT_NOQUOTES), MB_CASE_TITLE),
            'country' => mb_convert_case($this->pure($post['country'],ENT_HTML5), MB_CASE_TITLE),
        ];
        $this->db->query('UPDATE ' . $route['cat'] . ' SET name = :name, type = :type, country = :country,
         description = :text WHERE id = :id', $params);
        return true;
    }

    public function ItemExists($cat, $id)
    {
        return $this->db->column("SELECT id FROM " . $cat . " WHERE id = ".$id."");
    }

    public function DeleteItem($cat, $id)
    {
        unlink($this->db->column("SELECT image FROM " . $cat . " WHERE id = " . $id . " "));
        return $this->db->query("DELETE FROM " . $cat . " WHERE id = " . $id . " ");
    }

    public function items_title($get)
    {
        if (!array_key_exists($get, $this->cats)) {
            View::ErrorStatus(404);
        }
        return $this->cats[$get];
    }

    public function Items($type, $table, $route): array
    {

        $max = 10;
        $params = [
            'max' => $max,
            'start' => ((($_GET['page'] ?: 1) - 1) * $max),
        ];

        if ($type == 'all')
            $data = $this->db->row('SELECT * FROM ' . $table .' LIMIT :start, :max', $params);
        elseif ($type == 'single') {
            $data = $this->db->row('SELECT * FROM ' . $route['cat'] . ' WHERE id = ' . $route['id'] . ' LIMIT :start, :max', $params);
        }

        return $data;
    }

    public function typeValid($post)
    {
        $namelen = iconv_strlen($post['name']);
        $aliaslen = iconv_strlen($post['alias']);

            if (empty($post['item-cat'])) {
                $this->error = 'Выберите категорию товара.';
                return false;
            }

            if (!array_key_exists($post['item-cat'], $this->cats)) {
                $this->error = 'Ошибка SQL-запроса';
                return false;
            }

            $query = $this->db->column(" SELECT name FROM varietes WHERE name = '" . $this->pure($post['name'],ENT_NOQUOTES) . "'");
            if ($query) {
                $this->error = 'Название фильтра должно быть уникальным!';
                return false;
            }

        if ($namelen < 5 || $namelen > 50) {
            $this->error = 'Поле "Название фильтра" должно содержать от 5 до 50 символов';
            return false;
        }
        if ($aliaslen < 4 || $aliaslen > 50 || !preg_match("/[a-z]/", $post['alias'])) {
            $this->error = 'Поле "Псевдоним" должно содержать от 4 до 50 латинских символов';
            return false;
        }
        return true;
    }

    public function addType($post)
    {
        $params = [
            'id' => null,
            'name' =>  mb_convert_case($this->pure($post['name'],ENT_HTML5), MB_CASE_TITLE),
            'alias' => mb_convert_case($this->pure($post['alias'], ENT_HTML5), MB_CASE_LOWER),
            'category' => $this->pure($post['item-cat'], ENT_HTML5),
        ];

        $this->db->query("INSERT INTO varietes VALUES (:id,:name, :alias, :category)", $params);
        return true;
    }
}