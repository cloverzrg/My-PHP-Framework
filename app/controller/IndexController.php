<?php
/**
 * Created by PhpStorm.
 * User: zhurungen
 * Date: 2017/11/4
 * Time: 16:37
 */

namespace app\controller;

use core\lib\Request;
use core\lib\Controller;
use core\lib\Model;
use core\lib\Cache;
use core\lib\Config;
use core\lib\connection\Redis;
use core\lib\CSRF;
use core\lib\Session;
use core\lib\Debug;
//use \core\lib\Response;

/**
 * Class IndexController
 * @package app\controller  可以不继承父类
 */
class IndexController extends Controller
{

    public function index()
    {


        //Response::send();
        // 获取表单参数
        $name = Request::get("name");
        $user = Request::post("user");
        echo 'get:'.$name . '<br>';
        echo 'post:'.$user . '<br>';

        // 缓存
        Cache::set("cache_name", 1, 60);
        Cache::inc("cache_name", 2);
        $var = Cache::get("cache_name");
        echo 'cache:'.$var . '<br>';

        // 获取配置
        // 这里的 p() 函数是打印数组的自定义函数
        $all_config = Config::get();
        echo 'all_config:' ;
        p($all_config);

        // Redis 连接
        // db 选择 1
        $redis = Redis::getInstance(3);
        $redis->set("test", "redis_test_value", 5);
        $var = $redis->get("test");
        echo $var . '<br>';


        //CSRF token
        echo 'CSRF-Token : ' . CSRF::getToken() . '<br>';


        //session
        $a = array(1 => 2, 3 => 4);
        Session::set('session_test', $a);
        p(Session::get('session_test'));


        p($_SERVER);
        Debug::remark("b");
        echo Debug::getRangeTime('a','b');
    }
}