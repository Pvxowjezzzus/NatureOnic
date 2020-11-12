<?php


namespace app\models;
use app\controllers\MainController;
use app\core\Model;
class Main extends Model
{
    public function ItemCount($route) {
        return $this->db->column("SELECT COUNT(id) FROM ".$route['action']." ");
    }
    public function showItems($route)
    {
        $max = 9;
        $params = [
            'max' => $max,
            'start' => ((($route['page'] ?: 1) - 1) * $max),
        ];
      $items =  $this->db->row('SELECT * FROM '.$route['action'].' ORDER BY id DESC LIMIT :start, :max', $params);
        foreach ($items as &$val) {
          $val['name'] =  mb_convert_case($val['name'], MB_CASE_TITLE);
          $val['country'] = mb_convert_case($val['country'], MB_CASE_TITLE);
          $val['description'] = mb_convert_case($val['description'], MB_CASE_TITLE);
        }
        return $items;
    }
}