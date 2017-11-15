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
        echo $name . '<br>';
        echo $user . '<br>';

        // 缓存
        Cache::set("cache_name", 1, 60);
        Cache::inc("cache_name", 2);
        $var = Cache::get("cache_name");
        echo $var . '<br>';

        // 获取配置
        // 这里的 p() 函数是打印数组的自定义函数
        $redis_config = Config::get("REDIS");
        p($redis_config);
        //获取的配置不存在则返回默认值
        echo Config::get("test.test",'defaultValue').'<br>';

        // Redis 连接
        // db 选择 1
        $redis = Redis::getInstance(1);
        $redis->set("test", "test_value");
        $var = $redis->get("test");
        echo $var . '<br>';


        //CSRF token
        echo 'CSRF-Token : ' . CSRF::getToken() . '<br>';

        p($_SERVER);

    }
}