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
use core\lib\Config;

class Redis extends SessionHandler
{
    protected $handle = null;

    private $config = [
        'host' => '127.0.0.1',
        'port' => 6379,
        'password' => '',
        'select' => 0,
        'expire' => 3600,
        'timeout' => 0,
        'persistent' => true,
        'session_prefix' => 'session:',
    ];

    public function __construct(array $config = [])
    {
        //覆盖默认值
        if(is_null($config)){
            $config = Config::get('session.redis');
        }
        $this->config = array_merge($this->config, $config);
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
        return $this->handle->delete($this->config['session_prefix'].$session_id);
    }

    public function gc($maxlifetime)
    {
        return true;
    }

    public function open($save_path, $session_name)
    {
        $this->handle = RedisConnect::getInstance($this->config);
        return true;
    }

    public function read($session_id)
    {
        return $this->handle->get($this->config['session_prefix'].$session_id);
    }

    public function write($session_id, $session_data)
    {
        return $this->handle->setex($this->config['session_prefix'].$session_id, $this->config['expire'], $session_data);
    }

}