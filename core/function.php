<?php
/**
 * Created by PhpStorm.
 * User: zhurungen
 * Date: 2017/11/4
 * Time: 3:25
 *
 * 框架函数库
 */

function p($var)
{
    if (is_bool($var) || is_null($var)) {
        var_dump($var);
    } else {
        echo '<pre>' . print_r($var, true) . '</pre>';
    }
}