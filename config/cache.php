<?php
/**
 * Created by PhpStorm.
 * User: zhurungen
 * Date: 2017/11/6
 * Time: 22:40
 */

return [
    'config_prefix' => 'cache',
    'driver' => 'redis',
    'cache_prefix' => 'cache:',
    'redis' => array(
        'host' => '127.0.0.1',
        'port' => 6379,
        'password' => '',
        'persistent' => false,
        'select' => 0,
    ),
    'memcached' => array(
        'host' => '127.0.0.1',
        'port' => 11211,
    ),
];