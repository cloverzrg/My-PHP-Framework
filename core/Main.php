<?php
/**
 * Created by PhpStorm.
 * User: zhurungen
 * Date: 2017/11/4
 * Time: 3:36
 */

namespace core;

use core\lib\Route;
use core\lib\Request;
use core\lib\Config;
use core\lib\Cache;
use core\lib\CSRF;
use core\lib\Session;
use core\lib\Debug;

class Main
{

    // 框架流程控制
    public static function start()
    {
        Debug::remark("a");
        // 路由
        $controller_name = Route::getController();
        $action_name = Route::getAction();

        // 初始化各个类
        Request::init();
        Config::init();
        Cache::init();
        Session::init();

        //初始化框架
        self::init();


        // 引入控制器
        $class_file = APP . 'controller' . DS . $controller_name . 'Controller.php';
        $class_name = '\\app\\controller\\' . $controller_name . 'Controller';

        if (is_file($class_file)) {
            require_once $class_file;
            $controller = new $class_name;
            $controller->$action_name();
        } else {
            throw new \Exception("找不到控制器:" . $controller_name);
        }

    }


    //初始化
    private static function init()
    {
        // 调试模式
        if (Config::get('DEBUG')) {
            $whoops = new \Whoops\Run;
            $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
            $whoops->register();
            ini_set('display_error', 'On');
        } else {
            ini_set('display_error', 'Off');
        }

        // CSRF 防护
        if (Config::get('CSRF')) {
            // 开启防护的话,会对所有post请求检查 Token
            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                CSRF::check();
            }
        }
    }

    //自动加载类
    public static function loader($class)
    {
        // 目录分隔符
        $class = str_replace('\\', DS, $class);

        $classFile = BASE_PATH . $class . '.php';

        if (is_file($classFile)) {
            require_once $classFile;
            return true;
        } else {
            throw  new \Exception("文件加载失败,找不到类:" . $classFile);
        }

    }


}