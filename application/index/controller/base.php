<?php
/**
 * Created by PhpStorm.
 * User: lt
 * Date: 2017/11/30
 * Time: 20:37
 */

namespace app\index\controller;


use think\Controller;

class base extends Controller
{
    public function _initialize(){
        session([
            'prefix'     => '',
            'type'       => '',
            'auto_start' => true,
        ]);
        if (session('?email')) {
            header("location:index/index/index");
        }
        if (!session('?email')) {
            header("location:index/user/login");
        }

    }
}