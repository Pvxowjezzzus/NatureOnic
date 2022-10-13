<?php
use app\core\Router;
spl_autoload_register(function ($class){
$path = str_replace('\\','/', $class.'.php');
if(file_exists($path)) {
    require $path;
}
});

function startSession($isUserActivity=true) {
    $sessionLifetime = 1800;
    $url = parse_url($_SERVER['REQUEST_URI']);
    if ( session_id() ) return true;
    ini_set('session.cookie_lifetime', 0);
    ini_set('session.use_strict_mode', 1);
    if ( !session_start()) return false;
    $time = time();
    if ($sessionLifetime) {

        if (isset($_SESSION['lastactivity'])  && $_SESSION['admin'] == 1 && strpos($url['path'], '/admin') !== false  && $time-$_SESSION['lastactivity'] >= $sessionLifetime ) {
                    destroySession();
                    exit(header( "Refresh:0 url=/admin/login"));
        }
        else {
            if ( $isUserActivity ) $_SESSION['lastactivity'] = $time;
        }
    }

    return true;
}
function destroySession() {
    if ( session_id() ) {
        session_unset();
        unset($_SESSION['lastactivity']);
        setcookie(session_name(), session_id(), time()-60*60*24);
        session_destroy();
    }
}
startSession();
session_start();
$router = new Router;
$router->run();
?>