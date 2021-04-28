<?php


namespace app\core;
use app\libs\Db;

abstract class Model
{
public $db;
public $error;
public array $annotation;
    public function __construct()
    {
        $this->db = new Db();
    }


    public function pure($str, $flags)
    {
        return trim(htmlentities(strip_tags($str), $flags, "UTF-8"));
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