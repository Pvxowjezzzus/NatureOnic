<?php


namespace app\models;


use app\core\Model;
use app\core\Controller;
use app\core\View;
use app\libs\Images;

class Admin extends Model
{
    public $data;
    private $cats = [
        'fruits'=> 'Фрукты',
        'vegies' => 'Овощи',
        'nuts' => 'Орехи'
        ];

    public function ipList()
    {
        $white_list = array(
         '127.0.0.1',
        );

        if (in_array($_SERVER['REMOTE_ADDR'], $white_list)) {
            return true;
        }
    }
    public function AuthValid($post) {

        if(empty($post['login'] and $post['password'])) {
            $this->error = 'Заполните все поля!';
            return false;
        }
        $params = [
          'login' => $post['login'],
          'password' => $post['password'],
        ];
        $query = $this->db->column('SELECT login FROM users WHERE   login = :login AND password = :password OR email = :login AND  password = :password', $params);
        if(!$query)
        {
            $this->error = "Ошибка аутентификации\n 'Логин' или 'Пароль' неправильный";
            return false;
        }
            $_SESSION['admin'] = 1;
            $_SESSION['login'] = $query;
            $this->data = $query;
            return true;
    }


    public function postValid($post, $type) {
        $namelen = iconv_strlen($post['name']);
        $desclen = iconv_strlen($post['description']);
        if(empty($post['item-cat'])) {
            $this->error = 'Выберите категорию товара.';
            return false;
        }

        if(!array_key_exists($post['item-cat'], $this->cats)) {
            $this->error = 'Ошибка SQL-запроса';
            return false;
        }

        if($namelen < 5 || $namelen > 100) {
            $this->error = 'Поле "Название" должно содержать от 5 до 100 символов';
            return false;
        }
        $query = $this->db->column(" SELECT name FROM ".$post['item-cat']." WHERE name = '".$this->pure($post['name'])."'");
        if($query) {
            $this->error = 'Название продукта должно быть уникальным!';
            return false;
        }
        if ($desclen < 20 || $desclen > 500) {
            $this->error = 'Поле "Описание" должно содержать от 20 до 500 символов';
            return false;
        }
        if(empty($post['country'])) {
            $this->error = 'Поле "Страна-производитель" не заполнено';
            return false;
        }
        if(empty($_FILES['image']['tmp_name']) && $type == "add"){
            $this->error = 'Изображение не выбрано';
            return false;
        }

        $allowedtypes = ['image/gif','image/jpeg', 'image/jpg', 'image/png'];
        if(!in_array($_FILES["image"]["type"], $allowedtypes)) {
            $this->error = 'Запрещенный тип файла';
            return false;
        }
        return true;
    }
    public function uploadImage($part)
    {
        $path = "public_html".$part;
        static $randStr = '0123456789abcdefghijklmnopqrstuvwxyz';
        $randname = '';
        for ($i = 0; $i < 10; $i++) {
            $key = rand(0, strlen($randStr) - 1);
            $randname .= $randStr[$key];
        }
        $uploadImage = $_FILES['image'];
        $uploadImageName = trim(strip_tags($uploadImage['name']));
        $extension = pathinfo($uploadImageName, PATHINFO_EXTENSION);
        $file = $randname.'.'.$extension;
        if (!move_uploaded_file($_FILES['image']['tmp_name'], "$path$file")) {
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

    public function AddItem($post) {
        $params = [
            'id' => null,
            'name' => $this->pure($post['name']),
            'text' => $this->pure($post['description']),
            'country'=>$this->pure($post['country']),
            'images' =>    $this->uploadImage("/content/images/"),
            'created_at' => date("Y-m-d H:i:s"),

        ];

        $this->db->query("INSERT INTO ".$post['item-cat']."  VALUES (:id, :name, :country, :text,:images, :created_at)", $params);
        return true;
    }
    public function ItemExists($cat, $id)
    {
        return $this->db->column("SELECT id FROM ".$cat." WHERE id = ".$id."");
    }
    public function DeleteItem($cat, $id)
    {
        unlink($this->db->column("SELECT image FROM ".$cat." WHERE id = ".$id." "));
        return $this->db->query("DELETE FROM ".$cat." WHERE id = ".$id." ");
    }

    public function items_title($get)
    {
        if(!array_key_exists($get['cat'], $this->cats)) {
            View::ErrorStatus(404);
        }
        return $this->cats[$get['cat']];
    }

    public function Items()
    {
      $table = $_GET['cat'];
        $items =  $this->db->row('SELECT * FROM '.$table.'');
        foreach ($items as &$val) {
            $val['name'] =  mb_convert_case($val['name'], MB_CASE_TITLE);
            $val['country'] = mb_convert_case($val['country'], MB_CASE_TITLE);
            $val['description'] = mb_convert_case($val['description'], MB_CASE_TITLE);
        }
        return $items;
    }
}