<?php
/**
 * Created by PhpStorm.
 * User: lt
 * Date: 2017/12/2
 * Time: 01:11
 */

namespace app\index\controller;


use think\Controller;
use think\Db;

class Search extends Controller
{
    /*public function search(){

        $userModel = new \app\index\model\User();


        if (!session('?ext_user')) {
            header(strtolower("location: "."/mbook/public/index.php"."/index/user/login"));
            exit();
        }
        Db::query("select * from sc_comd where oname like '%?%'");
        return $this->fetch();

    }*/
    public function search(){
        return $this->fetch();
    }

    public function resule(){
        $keyword = $_GET['search'];
        $re=test($keyword);
        echo json_encode($re);//输出查询的结果（json格式输出）
        var_dump(json_encode($re));
    }

    public function test($keyword){//从数据库中查找关键字的函数
        $u = new \app\index\model\Book();
        //这里我做的一个模糊查询到名字或者对应的id,主要目的因为我这个系统是
        //商城系统里面用到直接看产品ID
        $map['book_id|book_author|book_isbn|book_directory|book_about']  = array('like','%'.$keyword.'%');
        $result=$u->where($map)->select();
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

}