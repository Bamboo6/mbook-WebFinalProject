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

        $get    = input('get.');
        $phone    = input('get.phone');
        $email    = input('get.email');

        $pageParam    = ['query' =>[]];

        if ($phone) {
            $userModel->where('phone', 'like', "%{$phone}%");
            $this->assign('phone', $phone);
            $pageParam['query']['phone'] = $phone;
        }
        if ($email) {
            $userModel->where('email', 'like', "%{$email}%");
            $this->assign('email', $email);
            $pageParam['query']['email'] = $email;
        }

        $list = $userModel->paginate(3, false, $pageParam);
        $this->assign('list', $list);

        $this->assign('title', '会员列表');
        $this->assign('breadcrumb', ['后台首页', '用户管理', '会员列表']);

        return $this->fetch();
    }
}