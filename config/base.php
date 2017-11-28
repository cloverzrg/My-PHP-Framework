<?php
/**
 * Created by PhpStorm.
 * User: zhurungen
 * Date: 2017/11/4
 * Time: 3:02
 *
 * 用于应用通用设置
 */

/*
 * 程序中如何获取配置文件的值?
 * use core/lib/Config;
 * Config::get('redis');  返回数组
 * Config::get('redis.host');  返回值
 */
return [
    // 调试模式
    'debug' => true,

    /**
     * CSRF防护,打开后每个 post 请求都需要携带 _token 字段,可以通过 CSRF::getToken()获取token
     * 打开后表单需要增加的字段 <input type="hidden" name="_token" value="{$token}" />
     * get方式不做检查,而且 get 请求不应该对数据库造成影响
     */
    'CSRF' => true,

    /**
     * redis配置
     * 当使用 pconnect 的时候，同一个 redis 服务器连接将使用最后一个select的数据库
     */
    'redis' => [
        'host' => '127.0.0.1',
        'port' => '6379',
        'password' => '',
        'select' => 0,
        // 是否使用 pconnect
        'persistent' => false,
    ],

];