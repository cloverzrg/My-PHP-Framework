<?php
/**
 * Created by PhpStorm.
 * User: nestleqkl
 * Date: 2017/11/16
 * Time: 2:18
 */

namespace core\lib\session\driver;

use SessionHandler;
use core\lib\connection\Redis as RedisConnect;

class Redis extends SessionHandler
{
    protected $handle = null;

    public function __construct()
    {

    }

    public function close()
    {
        return true;
    }

//    public function create_sid()
//    {
//        return session_regenerate_id(true);
//    }

    public function destroy($session_id)
    {
        return $this->handle->delete($session_id);
    }

    public function gc($maxlifetime)
    {
        return true;
    }

    public function open($save_path, $session_name)
    {
        $this->handle = RedisConnect::getInstance();
        return true;
    }

    public function read($session_id)
    {
        return $this->handle->get($session_id);
    }

    public function write($session_id, $session_data)
    {
        return $this->handle->set($session_id,$session_data);
    }

}