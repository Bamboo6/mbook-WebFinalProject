<?php
/**
 * Created by PhpStorm.
 * User: lt
 * Date: 2017/12/2
 * Time: 01:28
 */

namespace app\index\controller;


use think\Controller;

class Feedback extends Controller
{
    public function feedback(){
        if (!session('?ext_user')) {
            header(strtolower("location: "."/mbook/public/index.php"."/index/user/login"));
            exit();
        }
        return $this->fetch();
    }
    public function feedbackdo(){
        $u=new \app\index\model\Feedback();
        $feedback=\think\Request::instance()->post('feedback');
        $data['feedback_info']=$feedback;
        $u->insert($data); // 插入数据库
        $this->success("<h1>反馈成功</h1>","index/index/index");
    }
}