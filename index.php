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
    if ( session_id() ) return true;
    ini_set('session.cookie_lifetime', 0);
    ini_set('session.use_strict_mode', 1);
    if ( ! session_start() ) return false;
    $t = time();
    if ( $sessionLifetime ) {

        if ( isset($_SESSION['lastactivity']) && $t-$_SESSION['lastactivity'] >= $sessionLifetime ) {
            destroySession();
                $url = parse_url($_SERVER['REQUEST_URI']);
                if($url['path'] === '/admin-panel' || $url['path'] === "/admin/" ) {
                    exit(header( "Refresh:0 url=/admin/login"));
                }

        }
        else {
            if ( $isUserActivity ) $_SESSION['lastactivity'] = $t;
        }
    }

    return true;
}
function destroySession() {
    if ( session_id() ) {
        session_unset();
        setcookie(session_name(), session_id(), time()-60*60*24);
        session_destroy();
    }
}
startSession();
session_start();
$router = new Router;
$router->run();