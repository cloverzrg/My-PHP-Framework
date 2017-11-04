<?php
/**
 * Created by PhpStorm.
 * User: zhurungen
 * Date: 2017/11/4
 * Time: 3:36
 */

namespace core;

use \core\lib\route;
use \core\lib\request;

class main
{

    // 框架流程控制
    public static function start()
    {
        // 路由
        $controller = route::getController();
        $action = route::getAction();

        // 初始化请求类
        request::init();

        // 引入控制器
        $class_file = APP.'controller'.DS.$controller.'Controller.php';
        $class_name = '\\app\\'.'controller\\'.$controller.'Controller';

        if (is_file($class_file)){
            require_once $class_file;
            $contr = new $class_name;
            $contr->$action();
        }else{
            throw new \Exception("找不到控制器");
        }

    }


    //初始化
    private static function init()
    {

    }

    //自动加载类
    public static function loader($class)
    {
        // windows 目录分隔符
        $class = str_replace('\\', DS, $class);

        $class_file = BASE_PATH . $class . '.php';

        if (is_file($class_file)) {
            require_once $class_file;
            return true;
        } else {
            return false;
        }

    }


    // 显示页面
    public static function display()
    {

    }
}