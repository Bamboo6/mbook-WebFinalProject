<?php
/**
 * Created by PhpStorm.
 * User: lt
 * Date: 2017/12/2
 * Time: 21:01
 */

namespace app\index\controller;


use think\Controller;

class Contact extends Controller
{
    public function contact(){
        if (!session('?ext_user')) {
            header(strtolower("location: "."/mbook/public/index.php"."/index/user/login"));
            exit();
        }
        return $this->fetch();
    }

    public function baidumap(){
        if (!session('?ext_user')) {
            header(strtolower("location: "."/mbook/public/index.php"."/index/user/login"));
            exit();
        }
        return $this->fetch();
    }
}