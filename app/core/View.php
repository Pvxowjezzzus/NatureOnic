<?php


namespace app\core;


class View
{
    public $path;
    public $layout = 'default';

    public function __construct($route) {
        $this->path = $route['controller'].'/'.$route['action'];
    }

    public function render($title, $vars = []) {
        extract($vars);
        $path = 'app/views/'.$this->path.'.php';
        if (file_exists($path)) {
            ob_start();
            require $path;
            $content = ob_get_clean();
            require 'app/views/layouts/'.$this->layout.'.php';
        }
    }
   
    public function redirect($url) {
        header('location: /'.$url);
        exit;
    }

    public static function ErrorStatus($code)
    {
        http_response_code($code);
        $path = 'app/views/errors/'.$code.'.php';
        if(file_exists($path)) {
            require $path;
        }
        exit;
    }
    public function ItemCount($nuts, $driedfruits) {
        exit(json_encode(['nuts'=>$nuts, "driedfruits"=>$driedfruits]));
    }
    public function message($status, $message)
    {
        exit(json_encode(['status'=>$status, 'message'=>$message]));
    }

	public function form_valid($object, $status, $message)
	{
		exit(json_encode(['object'=>$object, 'status' => $status, 'message'=> $message]));
    }

   

    public function location($status,$url)
    {
        exit(json_encode(['status' => $status,'url'=>$url]));
    }
}
?>