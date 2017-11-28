<?php
/**
 * Created by PhpStorm.
 * User: nestleqkl
 * Date: 2017/11/16
 * Time: 2:54
 */


return [
    'config_prefix' => 'session',
    // 如果使用服务器默认的方式,则type设置为default
    'type' => 'Redis',

    'redis' => [
        'host' => '127.0.0.1',
        'port' => 6379,
        'password' => '',
        'select' => 1,
        'expire' => 3600,
        'timeout' => 0,
        'persistent' => false,
        'session_prefix' => 'session:',
    ]
];