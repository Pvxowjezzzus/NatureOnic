<?php


namespace app\core;
use app\libs\Db;

abstract class Model
{
public $db;

    public function __construct()
    {
        $this->db = new Db();

    }


    public function pure($str)
    {
        return trim(htmlentities(strip_tags($str), ENT_QUOTES, "UTF-8"));
    }
}