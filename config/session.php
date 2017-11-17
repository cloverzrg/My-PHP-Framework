<?php
/**
 * Created by PhpStorm.
 * User: nestleqkl
 * Date: 2017/11/16
 * Time: 2:54
 */


return [
    'config_prefix' => 'session',
    'type' => 'Redis',

    'Redis' => [
        'host' => '127.0.0.1',
        'port' => 6379,
        'password' => '',
        'select' => 0,
        'expire' => 3600,
        'timeout' => 0,
        'persistent' => true,
        'session_prefix' => 'session:',
    ]
];