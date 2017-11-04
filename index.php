<?php
/**
 * Created by PhpStorm.
 * User: zhurungen
 * Date: 2017/11/4
 * Time: 2:33
 *
 * 入口文件
 * 1.定义常量
 * 2.加载函数库
 * 3.启动框架
 */

namespace core;

// 定义常量
define('VERSION', '0.1');
define('DS', DIRECTORY_SEPARATOR);
define('BASE_PATH', __DIR__ . DS);
define("CORE", BASE_PATH . 'core' . DS);
define('CONFIG_PATH', BASE_PATH . 'config' . DS);
define("APP", BASE_PATH . 'app' . DS);

// 加载框架函数库
require_once CORE . 'function.php';

// 加载应用函数库
require_once APP . 'function.php';

// 框架
require_once CORE . 'Main.php';

// 注册自动加载类
spl_autoload_register('\core\Main::loader');

// 启动框架
Main::start();