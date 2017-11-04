<?php
/**
 * Created by PhpStorm.
 * User: zhurungen
 * Date: 2017/11/4
 * Time: 15:54
 *
 * 请求类
 */

namespace core\lib;


class Request
{

    private static $get_data = array();
    private static $post_data = array();

    public static function get($key,$default = null)
    {
        if (isset(self::$get_data[$key])) {
            return self::$get_data[$key];
        } else {
            return $default;
        }
    }

    public static function post($key,$default = null)
    {
        if (isset(self::$post_data[$key])) {
            return self::$post_data[$key];
        } else {
            return $default;
        }
    }

    public static function init()
    {
        if (isset($_GET['s'])) {
            $str = $_GET['s'];
        } else {
            $str = '';
        }
        $arr = explode('/', trim($str, '/'));

        $len = count($arr);
        for ($i = 2; $i < $len; $i += 2) {
            if (isset($arr[$i + 1])) {
                self::$get_data[$arr[$i]] = $arr[$i + 1];
            }
        }
        foreach ($_POST as $key => $value) {
            self::$post_data[$key] = $value;
        }
    }
}