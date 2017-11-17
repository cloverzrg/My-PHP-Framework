<?php
/**
 * Created by PhpStorm.
 * User: nestleqkl
 * Date: 2017/11/15
 * Time: 23:18
 */


namespace core\lib;

use core\lib\Config;

class Session
{
    /**
     * 初始化 session
     * @param array $config
     */
    public static function init(array $config = [])
    {
        if(empty($config)){
            $config = Config::get('session');
        }
        $class = 'core\\lib\\session\\driver\\'.$config['type'];
        ini_set('session.auto_start', 0);
        ini_set('session.save_handler', 'user');
        session_set_save_handler(new $class());
        session_start();
    }

    public static function set(string $key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function get(string $key)
    {
        return $_SESSION[$key];
    }

    public static function delete(string $key)
    {
        unset($_SESSION[$key]);
        return true;
    }


}