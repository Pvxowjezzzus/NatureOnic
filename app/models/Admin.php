<?php


namespace app\models;


use app\core\Model;
use app\core\View;
use app\libs\Images;
use app\models\User;
use app\libs\PHPExcel;
use DateTime;
use PHPExcel_Cell_DataType;
use PHPExcel_IOFactory;

class Admin extends Model
{
	public $data;
    private $id;
    public $cats = [ 
        'nuts' => 'Орехи',
	    'driedfruits'=>'Сухофрукты',
    ];


    public function ipList(): bool // список ip-адресов
    {
        $white_list = array( // Массив разрешенных ip-адресов
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

    
    
	public function signup($post) // Регистрация аккаунта
	{
       
		$val = array_values($post);
		if(!$this->array_pass($post)) {
			$this->error =  array('form',"Все поля пусты");
			return false;
		}
        
        $email = $post['email'];
		$params = [
			'email' => $email,
		];
		$query = $this->db->row('SELECT email FROM users WHERE email = :email', $params);
		if ($query) {
			$this->error = array($email,'Данный email уже используется');
			return false;
		}
        $username = $post['username'];
		$params = [
			'username' => $username,
		];
        $query = $this->db->row('SELECT username FROM users WHERE username = :username', $params);
		if ($query) {
			$this->error = array($username,'Данное имя уже используется');
			return false;
		}
        
		if (empty($_POST['username']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['password_verify'])) {
			$this->error = array('form','Не заполнены все поля');
		}
			else {
				$params = [
					'id' => null,
					'username' => $this->pure($post['username'], ENT_NOQUOTES),
					'email' => $this->pure($post['email'], ENT_NOQUOTES),
					'password' => self::encryptPassword($post['password']),
					'created_at' => date("Y-m-d H:i:s")
				];
				$query = $this->db->query('INSERT INTO `users`(`id`, `username`, `email`, `password`, `created_at`) 
					VALUES (:id, :username, :email, :password, :created_at)', $params);
    
			}
            $this->id = $this->db->column('SELECT id FROM users ORDER BY id DESC LIMIT 1');
    
		return $query;
	}
    public function setRole($type) {
        $params = [
            'id' => $this->id,
        ];
        $user = $this->db->column('SELECT username FROM users WHERE id = :id',$params);
        if($type = 'user') {
            $params = [
                'id' => null,
                'user_id' => $this->id,
                'username' => $user,
                'role' => 'user',
                'permissions'=> 'items' 
            ];
            $this->db->query('INSERT INTO roles (`id`, `user_id`, `username`, `role`, `permissions`)
                            VALUES (:id, :user_id,:username, :role, :permissions)', $params);
         }

    }
    public function getUserData($type){
        if($type == 'all') 
            $query = $this->db->row('SELECT * FROM users');
        
        if($type == 'self') 
            $query = $this->db->row('SELECT * FROM users WHERE username = "'.$_SESSION['username'].'"');
        return $query;
    }
    
    public function getUserRole($type){
        if($type == 'all') 
            $query = $this->db->row('SELECT * FROM roles');
     
        if($type == 'self') 
            $query = $this->db->row('SELECT * FROM roles WHERE username = "'.$_SESSION['username'].'"');
        
        if($type == 'only-role') 
            $query = $this->db->column('SELECT role FROM roles WHERE username = "'.$_SESSION['username'].'"');
        
    
        return $query;
    }
    public function getRole($user){
        return $this->db->row('SELECT * FROM roles WHERE username = "'.$_SESSION['username'].'"');
    }
    public function AuthValid($post) // Аутентификация
    {
	    if(!$this->array_pass($post)) {
		    $this->error =  array('form',"Все поля пусты");
		    return false;
	    }

            if (empty($_POST['username']) || empty($_POST['password'])) {
            $this->error = array('form','Не заполнены все поля');
            }
            else {
	            $params = [
		            'username' => $post['username'],
		            'password' => self::encryptPassword($post['password']),
	            ];
	            $query = $this->db->row('SELECT username and password FROM users WHERE username = :username AND password = :password OR email = :username AND  password = :password', $params);
                $username = $this->db->column('SELECT username FROM users WHERE username = :username AND password = :password OR email = :username AND  password = :password', $params);
                $role = $this->db->column('SELECT role FROM roles WHERE username = "'.$post['username'].'"');
	            if (!$query) {
		            $this->error = array('error', "Ошибка входа\n «Имя пользователя» или «Пароль» неправильный");
		            return false;
	            } else {
		            $_SESSION['admin'] = 1;
                    $_SESSION['username'] = $username;
                    $_SESSION['role'] = $role;
		            return true;
	            }
            }
    }
    public function getPermissions() {
        $params = [
            'username'=>$_SESSION['username'],
        ];
      $query = $this->db->column('SELECT permissions FROM roles WHERE username = :username',$params);
      return $query;
    }

    public function changeEmail($post){
        if (empty($post['new_email'])) {
            $this->error = 'Не заполнено поле "Новый Email"';
            return false;
        }

        if(empty($post['password'])){
            $this->error = 'Не заполнено поле "Пароль"';
            return false;
        }
        
        if(!preg_match("/([a-zA-Z0-9]+@[a-zA-Z0-9]+\.[a-zA-Z0-9])/",$post['new_email'])) {
            $this->error = 'Неправильный формат эл.почты';
            return false;
        }
        $params = [
			'email' => $post['new_email'],
		];
        $query = $this->db->row('SELECT email FROM users WHERE email = :email', $params);
		if ($query) {
			$this->error = 'Данный Email используется вами сейчас';
			return false;
        }
        $params = [
			'password' => self::encryptPassword($post['password']),
		];
        $query = $this->db->row('SELECT id FROM users WHERE password = :password', $params);
		if (!$query) {
			$this->error = 'Введен неправильный пароль';
			return false;
        }
        
        else {
            $params = [
                'email' => $post['new_email'],
                'username' => $_SESSION['username'],
            ];
            $this->db->query('UPDATE users SET email = :email WHERE username = :username',$params);
            return true;
        }
    }

    public function changePassword($post){
        

        if(empty($post['password'])){
            $this->error = 'Не заполнено поле "Старый пароль"';
            return false;
        }
        
        if(empty($post['new_password'])){
            $this->error = 'Не заполнено поле "Новый пароль"';
            return false;
        }

        if(empty($post['verify_password'])){
            $this->error = 'Не заполнено поле "Подтверждение пароля"';
            return false;
        }


        $params = [
			'password' => self::encryptPassword($post['password']),
		];
        $query = $this->db->row('SELECT id FROM users WHERE password = :password', $params);
		if (!$query) {
			$this->error = 'Введен неправильный пароль';
			return false;
        }
        if(strlen($post['new_password']) < 8){
            $this->error = 'Длина нового пароля меньше 8 символов';
            return false;
        }
        
        $params = [
			'password' => self::encryptPassword($post['new_password']),
            'username'=> $_SESSION['username'],
		];
        $query = $this->db->row('SELECT id FROM users WHERE username = :username AND password = :password', $params);
		if ($query) {
			$this->error = 'Новый пароль совпадает с нынешним';
			return false;
        }
        if($post['new_password'] !== $post['verify_password']) {
            $this->error = 'Введенные пароли не совпадают';
			return false; 
        }
        else {
            $params = [
                'new_password' => self::encryptPassword($post['new_password']),
                'username' => $_SESSION['username'],      
            ];

            $this->db->query('UPDATE users SET password = :new_password WHERE username = :username',$params);
            return true;
        }
    }

    public function types($get) // Разновидности
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
    public function ItemCount($cat) { // Подсчёт товаров
        if($cat == 'all') {
            $query = $this->db->column(" SELECT COUNT(id) FROM products");
            return $query;
        }
        else {
            $this->product = array(
            "nuts"=>$this->db->column('SELECT COUNT(id) FROM products WHERE category = "nuts"'),
            "driedfruits"=>$this->db->column('SELECT COUNT(id) FROM products WHERE category = "driedfruits"'));
            return true;
        }
        
    }

    public function lastItemTime() {
        $query = $this->db->column('SELECT date FROM products ORDER BY id DESC LIMIT 1');
        $date = date_format(date_create($query), 'H:i');
        $day = date_format(date_create($query), 'd-m');
        if(date('d-m') !=  $day) {
            return date_format(date_create($query), 'd-m-y');
        }
        return $date;
    }

    public function postValid($post, $type)
    {
        $namelen = mb_strlen($post['name']);
        $desclen = mb_strlen($post['description']);
        if ($type == 'add') {
            if (empty($post['item-cat'])) {
                $this->error = 'Выберите категорию продукта';
                return false;
            }
            if(empty($post['item-kind'])){
                $this->error = 'Выберите разновидность продукта';
                return false;
            }
            if (!array_key_exists($post['item-cat'], $this->cats)) {
                $this->error = 'Ошибка SQL-запроса';
                return false;
            }
            $query = $this->db->column(" SELECT name FROM products WHERE name = '" . $this->pure($post['name'],ENT_NOQUOTES) . "'");
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
	    if (empty($post['price'])) {
		    $this->error = 'Поле "Цена продукта" не заполнено';
		    return false;
	    }
        if (empty($_FILES['image']['tmp_name']) && $type == 'add') {
            $this->error = 'Изображение не выбрано';
            return false;
        } elseif ($type == 'add') {

            $allowed_types = [IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_JPEG2000, IMAGETYPE_WEBP, IMAGETYPE_BMP, IMAGETYPE_GIF, IMAGETYPE_JPX];
            if (in_array(exif_imagetype($_FILES['image']['tmp_name']),$allowed_types)) {
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
        
        $pathh = realpath($_FILES['image']['name']);
        $path = "public_html".$part;
        static $randStr = '0123456789abcdefghijklmnopqrstuvwxyz';
        $randname = '';
        for ($i = 0; $i < 10; $i++) {
            $key = rand(0, strlen($randStr) - 1);
            $randname .= $randStr[$key];
        }
        
        $uploadImageName = trim(strip_tags($uploadImage));
        $path_info = pathinfo($uploadImageName);
        $extension =  $path_info['extension'];
        $file = $randname . '.' . $extension;
        if (!move_uploaded_file($tmpname, $path.$file)) {
            $this->error = 'Ошибка загрузки изображения';
            return false;

        } else
            $size = GetImageSize($path.$file);
        if ($size[0] > 360 || $size[1] > 240) {
            $image = new Images();
            $image->load($path.$file);
            $image->resize(360, 240);
            $image->save($path.$file);
        }
        return "$path$file";
    }

    public function AddItem($post)
    {
        $params = [
            'id' => null,
            'name' => mb_convert_case($this->pure($post['name'],ENT_NOQUOTES),MB_CASE_TITLE_SIMPLE),
	        'category' => $this->pure($post['cat'], ENT_NOQUOTES),
            'type' => $this->pure($post['item-kind'],ENT_NOQUOTES),
            'text' => ucfirst($this->pure($post['description'],ENT_NOQUOTES)),
            'country' => $this->pure($post['country'], ENT_NOQUOTES),
	        'price' => $this->pure($post['price'], ENT_NOQUOTES),
            'images' => $this->uploadImage("/content/images/"),
            'created_at' => date("Y-m-d H:i:s"),
        ];

        $this->db->query("INSERT INTO products VALUES (:id, :name, :category, :type, :country, :text, :price,:images, :created_at)", $params);
        return true;
    }

    public function EditItem($post, $route)
    {
        $params = [
            'id' => $route['id'],
            'name' => mb_convert_case($this->pure($post['name'], ENT_NOQUOTES), MB_CASE_TITLE),
            'type' => $this->pure($post['item-kind'],ENT_HTML5),
            'country' => $this->pure($post['country'],ENT_NOQUOTES),
            'text' => ucfirst($this->pure($post['description'],ENT_NOQUOTES)),
            'price' => $this->pure($post['price'], ENT_HTML5)
        ];
        $this->db->query('UPDATE products SET name = :name, type = :type, country = :country,
         description = :text, price = :price WHERE id = :id', $params);
        return true;
    }
    public function CheckChanges($post){
        $params = [
            'name' => mb_convert_case($this->pure($post['name'], ENT_NOQUOTES), MB_CASE_TITLE),
            'type' => $this->pure($post['item-kind'],ENT_HTML5),
            'country' => mb_convert_case($this->pure($post['country'],ENT_NOQUOTES), MB_CASE_TITLE_SIMPLE),
            'text' => mb_convert_case($post['description'],MB_CASE_TITLE_SIMPLE),
            'price' => $this->pure($post['price'], ENT_HTML5)
        ];
            $query = $this->db->column('SELECT id FROM products WHERE name = :name AND type = :type AND country = :country && 
            description = :text && price = :price', $params);
            if($query) {
                $this->error = 'Изменений нет.';
                return false;
            }
            else 
            return true;
        
    }

    public function ItemExists($id) // Проверка существования товара
    {
        return $this->db->column("SELECT id FROM products WHERE id = ". $id." ");
    }

    public function DeleteItem($id) // Удаление товара
    {
        unlink($this->db->column("SELECT image FROM products WHERE id = " . $id . " "));
        return $this->db->query("DELETE FROM products WHERE id = " . $id . " ");
    }


    public function Items($type, $route): array
    {
		$data = null;
        $max = 10;
        $params = [
            'max' => $max,
            'start' => ((($_GET['page'] ?: 1) - 1) * $max),
        ];

        if ($type == 'all')
            $data = $this->db->row('SELECT * FROM products LIMIT :start, :max', $params);
        elseif ($type == 'single')
            $data = $this->db->row('SELECT * FROM products WHERE id = ' . $route['id'] . ' LIMIT :start, :max', $params);
        elseif($type == 'everything')
            $data = $this->db->row('SELECT * FROM products');

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
            'name' =>  mb_convert_case($this->pure($post['name'],ENT_NOQUOTES ), MB_CASE_TITLE),
            'alias' => mb_convert_case($this->pure($post['alias'], ENT_HTML5), MB_CASE_LOWER),
            'category' => $this->pure($post['item-cat'], ENT_HTML5),
        ];

        $this->db->query("INSERT INTO varietes VALUES (:id,:name, :alias, :category)", $params);
        return true;
    }
    public function addCount() {

        $fileCount = $_SERVER['DOCUMENT_ROOT']."/app/counter/count.txt";
        $count = file($fileCount);
        $count = implode("", $count);
        if(!file_exists($fileCount)) {
            file_put_contents($fileCount, $count);
        }
         
        else {
            $count++;
            $f = fopen($fileCount, "w");
            fputs($f,$count);
            fclose($f); 
        }
    }
    public function resetCounter(){
        $fileCount = $_SERVER['DOCUMENT_ROOT']."/app/counter/count.txt";
        $day =date('d-m-y', filemtime($fileCount));
        if(date('d-m-y') !=  $day) {
            file_put_contents($fileCount, '0');
        
        }
    }
    public function NewItemsCount() { // Подсчёт добавленных товаров
        $file = $_SERVER['DOCUMENT_ROOT']."/app/counter/count.txt";
        $count = file_get_contents($file);
        return $count;
    }
    public function Requests($type, $route){
        $data = null;
        $max = 10;
        $params = [
            'max' => $max,
            'start' => ((($_GET['page'] ?: 1) - 1) * $max),
        ];

        if ($type == 'all')
            $data = $this->db->row('SELECT * FROM requests LIMIT :start, :max', $params);
        elseif ($type == 'single')
            $data = $this->db->row('SELECT * FROM requests WHERE id = ' . $route['id'] . ' LIMIT :start, :max', $params);
        return $data;
    }
    public function RequestsCount($cat) { // Подсчёт товаров
        if($cat == 'all') {
            $query = $this->db->column(" SELECT COUNT(id) FROM requests");
            return $query;
        }
    }
    public function Excel() {
        $titles = [
            array(
                "name"=> "Название",
                "cell"=>"A"
            ),

            array(
                "name"=> "Категория",
                "cell"=>"B"
            ),
            array(
                "name"=> "Разновидность",
                "cell"=>"C"
            ),
            array(
                "name"=> "Страна-производитель",
                "cell"=>"D"
            ),
            array(
                "name"=> "Описание",
                "cell"=>"E"
            ),
            array(
                "name"=> "Цена",
                "cell"=>"F"
            ),
            array(
                "name"=> "Дата создания",
                "cell"=>"G"
            ),
        ];
        include_once("app\libs\PHPExcel\PHPExcel.php");
        $phpexcel = new GlobalPHPExcel();
        for($i = 0; $i < count($titles); $i++) {
            $string = $titles[$i]['name'];
            $string = mb_convert_encoding($string, "UTF-8", "Windows-1251");
            $cellLetter = $titles[$i]['cell'] . 2;
            $phpexcel->getActiveSheet()->setCellValueExplicit($cellLetter, $string, PHPExcel_Cell_DataType::TYPE_STRING);
        }
        $i = 3;
        $items = $this->Items('everything', $this->route);
        foreach($items as $item) {
            $string = $item['name'];
            $string = mb_convert_encoding($string, "UTF-8", "Windows-1251");
            $phpexcel->getActiveSheet()->setCellValueExplicit("A$i",$string, PHPExcel_Cell_DataType::TYPE_STRING);
            $string = $item['category'];
            $string = mb_convert_encoding($string, "UTF-8", "Windows-1251");
            $phpexcel->getActiveSheet()->setCellValueExplicit("B$i",$string, PHPExcel_Cell_DataType::TYPE_STRING);
            $phpexcel->getActiveSheet()->setCellValue("C$i", $item['price']);

            $i++;
        }

        $phpexcel->getActiveSheet()->getColumnDimension('A')->setWidth(16);
        $phpexcel->getActiveSheet()->getColumnDimension('A')->setWidth(16);
        $phpexcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $page = $phpexcel->setActiveSheetIndex();
        $page->setTitle('Продукты');
        $objWriter = PHPExcel_IOFactory::createWriter($phpexcel,"Excel2016");
        $filename = "products.xlsx";
        if(file_exists($filename)) {
            unlink($filename);
        }
        $objWriter->save($filename);

    }
}
?>