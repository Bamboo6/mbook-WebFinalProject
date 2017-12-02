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
        return $this->fetch();
    }

    public function baidumap(){
        return $this->fetch();
    }
}