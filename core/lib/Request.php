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

    /**
     * @param $key  要获取的 get 参数
     * @param null $default 不存在时候的默认值
     * @return mixed|null
     */
    public static function get($key,$default = null)
    {
        if (isset(self::$get_data[$key])) {
            return self::$get_data[$key];
        } else {
            return $default;
        }
    }


    /**
     * @param $key 要获取的 post 参数
     * @param null $default 不存在时的默认值
     * @return mixed|null
     */
    public static function post($key,$default = null)
    {
        if (isset(self::$post_data[$key])) {
            return self::$post_data[$key];
        } else {
            return $default;
        }
    }

    /**
     * 把 get(index.php?s=/index/index/name/zhurungen) 和 post 数据装载进类
     */
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