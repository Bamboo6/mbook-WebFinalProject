<?php
/**
 * Created by PhpStorm.
 * User: lt
 * Date: 2017/12/2
 * Time: 01:11
 */

namespace app\index\controller;

use think\Db;
use think\View;

class Search extends \think\Controller
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
    public function searchresult(){
        return $this->fetch();
    }

    public function searchdo(){
        $view = new View();
        $keyword=input('get.keyword');
        $book=new \app\index\model\Book();
        //这里我做的一个模糊查询到名字或者对应的id,主要目的因为我这个系统是
        //商城系统里面用到直接看产品ID
        $map['book_id|book_author|book_isbn|book_directory|book_about']  = array('like','%'.$keyword.'%');
        $pageParam    = ['query' =>[]];
        $pageParam['query']['keyword'] = $keyword;
        $result=$book->where($map)->paginate(5,false, $pageParam);
        $page = $result->render();
        //var_dump($result);
        $this->assign('result',$result);
        $this->assign('page', $page);
        $this->assign('keyword', $keyword);
        /*header(strtolower("location: ".config('web_root')."/index/search/searchresult.html"));
        exit();*/
        $view->result = $result;
        $view->keyword = $keyword;
        $view->page = $page;

        return $view->fetch('search/searchresult');
    }
    /*public function search1(){
        $keyword = $_POST['search'];
        $Goods=M('tb_book');
        //这里我做的一个模糊查询到名字或者对应的id，主要目的因为我这个系统是
        //商城系统里面用到直接看产品ID
        $map['book_id|book_author|book_isbn|book_directory|book_about']  = array('like','%'.$keyword.'%');
        // 把查询条件传入查询方法
        if($goods=$Goods->where($map)->select())
        {
            $this->ajaxReturn($goods,'查询成功!',1);
        }else{
            $this->ajaxReturn(0,"查询失败,数据不存在！",0);
        }
    }*/
    /*public function get_ajax_crmname(){

        $keyword=input('post.keyword');
        $map['book_id|book_author|book_isbn|book_directory|book_about']  = array('like','%'.$keyword.'%');

        $result=M('tb_book')->where($map)->select();
        var_dump($result);
        $this->ajaxReturn($result);
    }*/
    /*public function result(){
        $keyword = $_GET['search'];
        $re=test($keyword);
        echo json_encode($re);//输出查询的结果（json格式输出）
        var_dump(json_encode($re));
    }*/

    /*public function test($keyword){//从数据库中查找关键字的函数
        $u = new \app\index\model\Book();
        //这里我做的一个模糊查询到名字或者对应的id,主要目的因为我这个系统是
        //商城系统里面用到直接看产品ID
        $map['book_id|book_author|book_isbn|book_directory|book_about']  = array('like','%'.$keyword.'%');
        $result=$u->where($map)->select();
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }*/

}