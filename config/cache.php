<?php
/**
 * Created by PhpStorm.
 * User: zhurungen
 * Date: 2017/11/6
 * Time: 22:40
 */

return [
    'CONFIG_PREFIX' => 'CACHE',
    'DRIVER' => 'Redis',
    'CACHE_PREFIX' => 'CACHE:',
    'REDIS' => array(
        'HOST' => '127.0.0.1',
        'PORT' => 6379,
        'PASSWORD' => '',
        'PERSISTENT' => '',
        'SELECT' => 1,
    ),
    'MEMCACHED' =>array(
        'HOST' => '127.0.0.1',
        'PORT' => 11211,
    ),
];