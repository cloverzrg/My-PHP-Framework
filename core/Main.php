<?php
/**
 * Created by PhpStorm.
 * User: zhurungen
 * Date: 2017/11/4
 * Time: 3:36
 */

namespace core;

use \core\lib\Route;
use \core\lib\Request;
use \core\lib\Config;
use \core\lib\CSRF;

class Main
{

    // 框架流程控制
    public static function start()
    {
        session_start();

        // 路由
        $controller = Route::getController();
        $action = Route::getAction();

        // 初始化各个类
        Request::init();
        Config::init();


        //初始化框架
        self::init();


        // 引入控制器
        $class_file = APP . 'controller' . DS . $controller . 'Controller.php';
        $class_name = '\\app\\' . 'controller\\' . $controller . 'Controller';

        if (is_file($class_file)) {
            require_once $class_file;
            $contr = new $class_name;
            $contr->$action();
        } else {
            throw new \Exception("找不到控制器");
        }

    }


    //初始化
    private static function init()
    {
        // 调试模式
        if (Config::get('DEBUG')) {
            ini_set('display_error', 'On');
        } else {
            ini_set('display_error', 'Off');
        }

        // CSRF 防护
        if (Config::get('CSRF')){
            // 开启防护的话,会对所有post请求检查 Token
            if ($_SERVER['REQUEST_METHOD']=="POST"){
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
            throw  new \Exception("文件夹在失败,找不到类:" . $classFile);
        }

    }


}