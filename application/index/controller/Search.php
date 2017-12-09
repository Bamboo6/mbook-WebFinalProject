<?php
/**
 * Created by PhpStorm.
 * User: lt
 * Date: 2017/12/2
 * Time: 01:11
 */

namespace app\index\controller;

use think\View;

class Search extends \think\Controller
{
    public function search(){
        if (!session('?ext_user')) {
            header(strtolower("location: "."/mbook/public/index.php"."/index/user/login"));
            exit();
        }
        return $this->fetch();
    }
    public function searchresult(){
        if (!session('?ext_user')) {
            header(strtolower("location: "."/mbook/public/index.php"."/index/user/login"));
            exit();
        }
        return $this->fetch();
    }

    public function searchdo(){
        $view = new View();
        $keyword=input('get.keyword');
        $book=new \app\index\model\Book();
        $map['book_id|book_author|book_isbn|book_directory|book_about']  = array('like','%'.$keyword.'%');
        $pageParam    = ['query' =>[]];
        $pageParam['query']['keyword'] = $keyword;
        $result=$book->where($map)->paginate(5,false, $pageParam);
        $page = $result->render();
        $this->assign('result',$result);
        $this->assign('page', $page);
        $this->assign('keyword', $keyword);
        $view->result = $result;
        $view->keyword = $keyword;
        $view->page = $page;

        return $view->fetch('search/searchresult');
    }
}