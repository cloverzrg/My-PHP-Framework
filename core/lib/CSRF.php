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
    public static $tokenHtmlField = '_token';
    private static $sessionKey = 'CSRF-TOKEN';
    private static $tokenLen = 8;
    private static $token = null;


    /**
     * @return bool 返回Token是否正确,错误将抛出异常
     * @throws \Exception
     */
    public static function check()
    {
        $_token = Request::post(self::$tokenHtmlField);
        if (strlen($_token) == self::$tokenLen && $_token == $_SESSION[self::$sessionKey]) {
            // CSRF-TOKEN 检查通过
            $_SESSION[self::$sessionKey] = '';
            return true;
        } else {
            throw new \Exception("CSRF-TOKEN 验证不通过");
        }
    }


    /**
     * @return string 返回生成的 CSRF-Token
     */
    private static function generateToken()
    {
        $token = bin2hex(openssl_random_pseudo_bytes(self::$tokenLen / 2));
        $_SESSION[self::$sessionKey] = $token;
        self::$token = $token;
        return $token;
    }

    /**
     * @return string 获取token,一个请求只生成一次
     */
    public static function getToken()
    {
        if (!is_null(self::$token)) {
            return self::$token;
        }
        return self::generateToken();
    }
}