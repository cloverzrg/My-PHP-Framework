<?php
/**
 * Created by PhpStorm.
 * User: zhurungen
 * Date: 2017/11/6
 * Time: 22:40
 */

return [
    'config_prefix' => 'cache',
    'driver' => 'Redis',
    'cache_prefix' => 'cache:',
    'Redis' => array(
        'host' => '127.0.0.1',
        'port' => 6379,
        'password' => '',
        'persistent' => true,
        'select' => 1,
    ),
    'Mencached' => array(
        'host' => '127.0.0.1',
        'port' => 11211,
    ),
];