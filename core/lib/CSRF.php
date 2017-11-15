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
use Exception;
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
        $token = Request::post(self::$tokenHtmlField);
        if (isset($_SESSION[self::$sessionKey]) && $token == $_SESSION[self::$sessionKey]) {
            // CSRF-TOKEN 检查通过
            return true;
        } else {
            throw new Exception("CSRF-TOKEN 验证不通过");
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
     * @return string 获取token,一个token在一个会话中有效
     */
    public static function getToken()
    {
        if (is_null(self::$token)) {
            // 当session中有token时,直接使用session中的token
            if (isset($_SESSION[self::$sessionKey])) {
                self::$token = $_SESSION[self::$sessionKey];
            } else {
                self::generateToken();
            }

        }
        return self::$token;
    }
}