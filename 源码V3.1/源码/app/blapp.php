<?php

namespace BL\app;

use BL\app\libs\Router;
use BL\app\libs\Log;

class blapp
{
    private static $instance = null;
    static $modelObj = null;
    function __construct()
    {
        spl_autoload_register(array($this, 'loadClass'));
    }
    static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new blapp();
        }
        return self::$instance;
    }
    public function loadClass($class)
    {
        $class = str_replace('BL\\app', '', $class);
        $class = str_replace('\\', '/', $class);
        $file = BL_ROOT . '' . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
        } else {
            $msg = $class . ' load fail.';
            Log::$type = '';
           // Log::write($msg);
            echo '<html><head><title>404</title><head><body>page not found.</body></html>';
            exit;
        }
    }
    public function run()
    {
        $router = Router::put();
        if (file_exists(BL_ROOT . '/controller/' . $router[0])) {
            $className = !isset($router[1]) ? 'main' : $router[1];
            $class = __NAMESPACE__ . '\\controller\\' . $router[0] . '\\' . $className;
            if ($className == 'main') {
                $method = isset($router[1]) && $router[1] ? $router[1] : 'index';
            } else {
                $method = isset($router[2]) && $router[2] ? $router[2] : 'index';
            }
        } else {
            $class =  __NAMESPACE__ . '\\controller\\' . $router[0];
            $method = isset($router[1]) && $router[1] ? $router[1] : 'index';

        }
        $object = new $class();
        $method = method_exists($object, $method) ? $method : 'index';
        $object->{$method}();

    }

       
}