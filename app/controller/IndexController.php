<?php
/**
 * Created by PhpStorm.
 * User: zhurungen
 * Date: 2017/11/4
 * Time: 16:37
 */

namespace app\controller;

use \core\lib\request;
use \core\lib\Controller;
use \core\lib\Model;

class IndexController extends Controller
{

    public function index()
    {
        echo 'here is index<br>';
        echo request::get("name");

        $a = new Model();
        $this->display();
    }
}