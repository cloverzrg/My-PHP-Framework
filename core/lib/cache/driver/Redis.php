<?php
/**
 * Created by PhpStorm.
 * User: zhurungen
 * Date: 2017/11/8
 * Time: 13:29
 */


namespace core\lib\cache\driver;

use core\lib\Config;
use core\lib\cache\CacheDriverInterface;
use core\lib\connection\Redis as RedisConnect;

class Redis implements CacheDriverInterface
{
    private $handle;

    private $config = [
        'host' => '127.0.0.1',
        'port' => 6379,
        'password' => '',
        'select' => 0,
        'expire' => 3600,
        'timeout' => 0,
        'persistent' => true,
        'cache_prefix' => 'cache:',
    ];

    /**
     * Redis constructor.
     */
    public function __construct($config = null)
    {
        //获取缓存redis配置
        //覆盖默认值
        if(is_null($config)){
            $config = Config::get('cache.redis');
        }
        $this->config = array_merge($this->config, $config);
        $this->handle = RedisConnect::getInstance($this->config);
    }


    /**
     * 获取缓存内容
     * @param string $key 缓存键
     * @param bool $default 不存在时的默认值
     * @return string|array 尝试json解码,解码成功则返回数组
     */
    public function get($key, $default = false)
    {
        $value = $this->handle->get($key);

        if (is_null($value)) {
            return $default;
        }

        $json_data = json_decode($value);

        return $json_data === null ? $value : $json_data;
    }

    /**
     * 设置缓存
     * @param string $key 缓存键
     * @param string|array $value 缓存值,数组会json编码
     * @param int $expire 过期时间,0为永久
     * @return mixed
     */
    public function set($key, $value, $expire = 0)
    {
        if (is_array($value) || is_object($value)) {
            $value = json_encode($value);
        }

        if (is_int($expire) && $expire) {
            $result = $this->handle->setex($key, $expire, $value);
        } else {
            $result = $this->handle->set($key, $value);
        }

        return $result;
    }

    /**
     * 缓存是否存在
     * @param string $key 缓存键
     * @return bool true or false
     */
    public function has($key)
    {
        if ($this->handle->get($key)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 自增
     * @param string $key 缓存键
     * @param int $step 步长
     * @return int 自增后的值
     */
    public function inc($key, $step = 1)
    {
        return $this->handle->incrby($key, $step);
    }

    /**
     * 自减
     * @param string $key 缓存键
     * @param int $step 步长
     * @return int 自减后的值
     */
    public function dec($key, $step = 1)
    {
        return $this->handle->decrby($key, $step);
    }

    /**
     * 清空缓存
     * @return mixed
     */
    public function clear()
    {
        $key = Config::get('cache_prefix') . '*';
        $this->handle->delete($this->handler->keys($key));
    }

    /**
     * 删除指定缓存
     * @param string $key
     * @return mixed
     */
    public function rm($key)
    {
        return $this->handle->delete($key);
    }

    /**
     * @return mixed 句柄对象
     */
    public function handler()
    {
        return $this->handle;
    }

}