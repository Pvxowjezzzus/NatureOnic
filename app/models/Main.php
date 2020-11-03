<?php


namespace app\models;
use app\controllers\MainController;
use app\core\Model;
class Main extends Model
{

    public function showItems($route)
    {

      $items =  $this->db->row('SELECT * FROM '.$route['action'].' ORDER BY date');
        foreach ($items as &$val) {
          $val['name'] =  mb_convert_case($val['name'], MB_CASE_TITLE);
          $val['country'] = mb_convert_case($val['country'], MB_CASE_TITLE);
          $val['description'] = mb_convert_case($val['description'], MB_CASE_TITLE);
        }
        return $items;
    }
}