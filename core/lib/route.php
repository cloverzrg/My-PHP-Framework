<?php
/**
 * Created by PhpStorm.
 * User: zhurungen
 * Date: 2017/11/4
 * Time: 3:49
 */

namespace core\lib;

class route
{
    private static $route = array();

    public function __construct()
    {
        echo '???';
        p($_SERVER);
    }

    public static function getRoute()
    {
        /*
         * get请求 index.php?s=/index/notice/aid/12
         * 找出控制器和方法
         */
        if (isset($_GET['s'])){
            $str = $_GET['s'];
        }else{
            $str = '';
        }

        $arr = explode('/', trim($str, '/'));
        self::$route = array('controller' => 'index', 'action' => 'index');

        // 空字符串 explode 返回array([0]=>'');
        if (isset($arr[0]) && $arr[0]) {
            self::$route['controller'] = $arr[0];
        } else {
            return self::$route;
        }
        if (isset($arr[1])) {
            self::$route['action'] = $arr[1];
        }

        return self::$route;
    }

    public static function getController()
    {
        if(!isset(self::$route['controller'])){
            self::getRoute();
        }
        return self::$route['controller'];
    }

    public static function getAction()
    {
        if(!isset(self::$route['action'])){
            self::getRoute();
        }
        return self::$route['action'];
    }
}