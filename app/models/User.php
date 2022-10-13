<?php


namespace app\models;


use app\core\Model;

class User extends Model
{


	public function checkUserLogin($login)
	{
		if (!preg_match('/^[a-zA-Zа-яёА-ЯЁ\s\-]+$/', $login))
		{
			$this->error = array('login','Неправильный формат Логина');
			return false;
		}
		return true;
	}

	public function checkUserEmail($email)
	{
		$params = [
			'email' => $email,
		];
		$query = $this->db->row('SELECT email FROM users WHERE email = :email', $params);
		if ($query) {
			$this->error = array($email,'Данный email уже используется');
			return false;
		}
		return true;
	}
	public static function Variable()
    {
        echo 'Вызов метода Variable';
    }

}