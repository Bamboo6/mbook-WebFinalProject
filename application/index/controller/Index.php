<?php
namespace app\index\controller;
use think\Db;

class Index  extends \think\Controller
{
    public function indexlogin()
    {
        if (!session('?ext_user')) {
            header(strtolower("location: ".config('web_root')."/index/user/login"));
            exit();
        }
        $book = new \app\index\model\Book();
		$data= $book->field('book_id, book_name, book_newprice ,book_img')->where('book_issepprice=1')->find();
		$this->assign('tejiabook',$data);
        $name = session('username');
        $this->assign('name',$name);
        return $this->fetch();
    }

    public function index(){
        return $this->fetch();
    }
}
