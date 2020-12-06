<?php


namespace app\libs;


class Pagination
{
    private $max = 6;
    private $route;
    private $index = '';
    private $current_page;
    private $total;
    private $limit;

    public function __construct($route, $total, $limit) {
        $this->route = $route;
        $this->total = $total;
        $this->limit = $limit;
        $this->amount = $this->amount();
        $this->setCurrentPage();
    }

    public function get() {
        $links = null;
        $limits = $this->limits();
        $html = '<div class="page-container middle"><div class="pagination"><ul>';
        for ($page = $limits[0]; $page <= $limits[1]; $page++) {
            if ($page == $this->current_page) {
                $links .= '<li><span>'.$page.'</span></li>';
            } else {
                $links .= $this->generateHtml($page);
            }
        }
        if (!is_null($links)) {
            if ($this->current_page > 1) {
                $links = $this->generateHtml($this->current_page-1, 'Назад').$links;
            }
            if ($this->current_page < $this->amount) {
                $links .= $this->generateHtml($this->current_page+1, 'Вперед');
            }
        }
        $html .= $links.' </ul></div></div>';
        return $html;
    }
    private function check_sorting() {
        if(isset($_GET['type']) && !empty($_GET['type'])) {
            $char = "&";
        }
        else {
            $char = "?";
        }
        if(isset($_GET['by']) && isset($_GET['dir']))
            return $char.'by='.$_GET['by'].'&dir='.$_GET['dir'];
    }

    private function generateHtml($page, $text = null) {
        if (!$text) {
            $text = $page;
        }
        if(isset($_GET['type']))
            $link = '<li><a  href="/'.$this->route['action'].'/'.$this->route['cat'].'/'.$page.'/?type='.$_GET['type'].$this->check_sorting().'">'.$text.'</a></li>';
        else
            $link = '<li><a  href="/'.$this->route['action'].'/'.$this->route['cat'].'/'.$page.$this->check_sorting().'">'.$text.'</a></li>';

        return $link;
    }

    private function limits() {
        $left = $this->current_page - round($this->max / 2);
        $start = $left > 0 ? $left : 1;
        if ($start + $this->max <= $this->amount) {
            $end = $start > 1 ? $start + $this->max : $this->max;
        }
        else {
            $end = $this->amount;
            $start = $this->amount - $this->max > 0 ? $this->amount - $this->max : 1;
        }
        return array($start, $end);
    }

    private function setCurrentPage() {
        if (isset($this->route['page'])) {
            $currentPage = $this->route['page'];
        } else {
            $currentPage = 1;
        }
        $this->current_page = $currentPage;
        if ($this->current_page > 0) {
            if ($this->current_page > $this->amount) {
                $this->current_page = $this->amount;
            }
        } else {
            $this->current_page = 1;
        }
    }

    private function amount() {
        return ceil($this->total / $this->limit);
    }
}