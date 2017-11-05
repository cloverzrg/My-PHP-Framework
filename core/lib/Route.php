<?php
/**
 * Created by PhpStorm.
 * User: zhurungen
 * Date: 2017/11/4
 * Time: 3:49
 *
 * 路由类
 */

namespace core\lib;

class Route
{
    private static $route = array();

    public function __construct()
    {
        echo '???';
        p($_SERVER);
    }


    /**
     * 解析 url ,获取控制器和方法名
     * @return array
     */
    public static function init()
    {
        /*
         * get请求 index.php?s=/index/notice/aid/12
         * 找出控制器和方法
         */
        if (isset($_GET['s'])) {
            $str = $_GET['s'];
        } else {
            $str = '';
        }

        $arr = explode('/', trim($str, '/'));
        self::$route = array('controller' => 'Index', 'action' => 'index');

        // 空字符串 explode 返回array([0]=>'');
        if (isset($arr[0]) && $arr[0]) {
            self::$route['controller'] = ucfirst($arr[0]);
        } else {
            return self::$route;
        }
        if (isset($arr[1])) {
            self::$route['action'] = $arr[1];
        }

        return self::$route;
    }

    /**
     * @return mixed 返回控制器名称
     */
    public static function getController()
    {
        if (!isset(self::$route['controller'])) {
            self::init();
        }
        return self::$route['controller'];
    }

    /**
     * @return mixed 返回控制器里面的方法名
     */
    public static function getAction()
    {
        if (!isset(self::$route['action'])) {
            self::init();
        }
        return self::$route['action'];
    }
}