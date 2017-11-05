<?php
/**
 * Created by PhpStorm.
 * User: zhurungen
 * Date: 2017/11/5
 * Time: 1:34
 *
 * CSRF 防御
 */

namespace core\lib;

use core\lib\Request;

class CSRF
{
    public static $token_key = '_token';
    private static $session_key = 'CSRF-TOKEN';
    private static $token_len = 32;
    private static $token = '';


    /**
     * @return bool 返回Token是否正确,错误将抛出异常
     * @throws \Exception
     */
    public static function check()
    {
        $_token = Request::post(self::$token_key);
        if (strlen($_token) == self::$token_len && $_token == $_SESSION[self::$session_key]) {
            // CSRF-TOKEN 检查通过
            $_SESSION[self::$session_key] = '';
            return true;
        } else {
            throw new \Exception("CSRF-TOKEN 验证不正确");
        }
    }


    /**
     * @return string 返回生成的 CSRF-Token
     */
    private static function generateToken()
    {
        $token = bin2hex(openssl_random_pseudo_bytes(self::$token_len / 2));
        $_SESSION[self::$session_key] = $token;
        self::$token = $token;
        return $token;
    }

    /**
     * @return string 获取token,一个请求只生成一次
     */
    public static function getToken()
    {
        if (strlen(self::$token) == self::$token_len) {
            return self::$token;
        }
        return self::generateToken();
    }
}