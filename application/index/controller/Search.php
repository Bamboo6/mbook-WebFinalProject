<?php
/**
 * Created by PhpStorm.
 * User: lt
 * Date: 2017/12/2
 * Time: 01:11
 */

namespace app\index\controller;


class Search
{
    public function search(){

        $userModel = new \app\index\model\User();



        return $this->fetch();

    }
}