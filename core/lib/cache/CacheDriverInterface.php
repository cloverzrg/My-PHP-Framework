<?php
/**
 * Created by PhpStorm.
 * User: zhurungen
 * Date: 2017/11/8
 * Time: 13:28
 *
 * 定义缓存驱动的命名和需要实现的方法,方便扩展
 */


namespace core\lib\cache;

interface CacheDriverInterface
{

    /**
     * 获取缓存内容
     * @param string $key 缓存键
     * @param bool $default 不存在时的默认值
     * @return mixed
     */
    public function get($key, $default = false);

    /**
     * 设置缓存
     * @param string $key 缓存键
     * @param string $value 缓存值
     * @param int $expire 过期时间,0为永久
     * @return mixed
     */
    public function set($key, $value, $expire = 0);


    /**
     * 缓存是否存在
     * @param string $key 缓存键
     * @return bool true or false
     */
    public function has($key);

    /**
     * 自增
     * @param string $key 缓存键
     * @param int $step 步长
     * @return int 自增后的值
     */
    public function inc($key, $step = 1);

    /**
     * 自减
     * @param string $key 缓存键
     * @param int $step 步长
     * @return int 自减后的值
     */
    public function dec($key, $step = 1);

    /**
     * 清空缓存
     * @return mixed
     */
    public function clear();

    /**
     * 删除指定缓存
     * @param string $key
     * @return mixed
     */
    public function rm($key);

    /**
     * @return mixed 句柄对象
     */
    public function handler();

}