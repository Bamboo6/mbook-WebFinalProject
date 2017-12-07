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
        $m=new \app\index\model\Feedback();
        $r = $m->where('feedback_isshow',1)->paginate(3);
        $page = $r->render();
        $this->assign('r',$r);
        $this->assign('page',$page);
        return $this->fetch();
    }
    public function feedbackdo(){
        $f=new \app\index\model\Feedback();
        $username= session('username');
        $info=input('post.feedback');
        $isshow="1";

        $datetime = date("Y-m-d H:i:s");
        $data['feedback_time']=$datetime;
        $data['feedback_username']=$username;
        $data['feedback_info']=$info;
        $data['feedback_isshow']=$isshow;
        $f->insert($data); // 插入数据库
        $this->success("<h1>反馈成功</h1>","index/feedback/feedback");

    }
}