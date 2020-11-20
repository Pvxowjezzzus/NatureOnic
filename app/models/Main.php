<?php


namespace app\models;
use app\controllers\MainController;
use app\core\Model;
use app\core\View;

class Main extends Model
{
    private $cats = [
        'fruits'=> 'Фрукты',
        'vegies' => 'Овощи',
        'nuts' => 'Орехи',
        'berries' => 'Ягоды',
        'shrooms' => 'Грибы',
    ];
    public function ItemCount($route) {

        if(isset($_GET['type'])) {
            $params =[

            ];
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
              $val['name'] =  mb_convert_case($val['name'], MB_CASE_TITLE);
              $val['country'] = mb_convert_case($val['country'], MB_CASE_TITLE);
              $val['description'] = mb_convert_case($val['description'], MB_CASE_TITLE);
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

    public function direction()
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
}