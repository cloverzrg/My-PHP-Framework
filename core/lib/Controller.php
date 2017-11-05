<?php
/**
 * Created by PhpStorm.
 * User: zhurungen
 * Date: 2017/11/4
 * Time: 17:01
 *
 * 控制器类
 */

namespace core\lib;

class Controller
{

    public function display($view = '')
    {
        /*
         * 显示view模板
         */
        echo 'display';
    }

    public function __call($name, $arguments)
    {
        // TODO: Implement __call() method.
        throw  new \Exception(get_class($this).'中找不到此方法:'.$name);
    }
}