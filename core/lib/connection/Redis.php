<?php
/**
 * Created by PhpStorm.
 * User: zhurungen
 * Date: 2017/11/4
 * Time: 20:18
 *
 * Redis 驱动
 */

namespace core\lib\connection;

use core\lib\Config;

/*
 * redis连接
 * 获取一个连接:
 * use \core\lib\driver\Redis;
 * Redis::getInstance();
 */

class Redis
{

    protected static $handler = [];

    private function __construct()
    {

    }


    /**
     *
     * @param array $option 连接的redis的host,port等信息
     * @param string $config_str 连接特征码
     */
    private static function connect($option, $config_str)
    {
        $host = $option['host'];
        $port = $option['port'];
        $connect_type = $option['persistent'] ? 'pconnect' : 'connect';
        $password = $option['password'];
        $select = $option['select'];
        self::$handler[$config_str] = new \Redis();
        self::$handler[$config_str]->$connect_type($host, $port);
        if ($password != '') {
            self::$handler[$config_str]->auth($password);
        }
        self::$handler[$config_str]->select($select);
    }

    /**
     * @param array|int $option 连接的redis的host,port等信息
     * @return object 连接已连接对象
     */
    public static function getInstance($option = null)
    {
        //如果是一个数字,则为默认redis配置和选择的库
        if (is_numeric($option)) {
            $select = $option;
            $option = Config::get('redis');
            $option['select'] = $select;
        } else {
            //如果没有传入则使用默认配置
            if (is_null($option)) {
                $option = Config::get('redis');
            }
        }

        $host = $option['host'];
        $port = $option['port'];
//        $connect_type = $option['PERSISTENT'];
        $password = $option['password'];
        $select = $option['select'];
        $config_str = $host . ':' . $port . ':' . $select;
        if (!isset(self::$handler[$config_str])) {
            self::connect($option, $config_str);
        }
        return self::$handler[$config_str];
    }

    private function __clone()
    {

    }
}