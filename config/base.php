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
 * 返回数组
 * Config::get('REDIS');
 * 返回具体值
 * Config::get('REDIS.HOST');
 */
return [
    'DEBUG' => true,

    'REDIS' => [
        'HOST'=>'127.0.0.1',
        'PORT'=>'6379',
        'PASSWORD'=>'',
    ],

];