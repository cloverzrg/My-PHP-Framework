<?php
/**
 * Created by PhpStorm.
 * User: zhurungen
 * Date: 2017/11/6
 * Time: 0:45
 */

namespace core\lib;

class Response
{
    private static $header = [];

    public function init()
    {
        self::$header['x-powered-by'] = Framework_NAME;
    }

    /**
     * @param $key  header的键名
     * @param $value  header值,如果键名存在,则值会在最后面添加 ';'.$value;
     * @return mixed header值
     */
    public static function header($key,$value)
    {
        if(isset(self::$header[$key])){
            self::$header[$key] .= ';'.$value;
        }else{
            self::$header[$key] = $value;
        }
        return self::$header[$key];
    }

    /**
     * 把header数组里面的全部设置到header中
     */
    private static function setHeader()
    {
        foreach(self::$header as $key => $value){
            if(is_null($value)){
                header($key);
            }else{
                header($key.':'.$value);
            }
        }
    }

    public static function send()
    {
        self::init();
        self::setHeader();
    }
}