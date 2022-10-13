<?php


namespace app\core;
use app\libs\Db;

abstract class Model
{
public $db;
public $error;
public $msg;
public $product;
public array $annotation;

protected array $valid = [
		'invalid'=> [],
		'data' => [],
	];
    public function __construct()
    {
        $this->db = new Db();
    }



    public function pure($str, $flags)
    {
        return trim(htmlentities(strip_tags($str), $flags, "UTF-8"));
    }



	public static function encryptPassword($password)
	{
		return hash('sha256', $password);
	}
	public function array_pass($array)
	{
		$i = 0;
		$count = count($array);
		foreach($array as $key => $val) {
			if($val == '')
				$i++;
		}
		if($i == $count)
			return false;
		else
			return true;
	}


}
?>