<?php
namespace app\index\controller;
use app\index\model\Bigtype;


class Book extends \think\Controller
{

	public function booktype()
    {
        if (!session('?ext_user')) {
            header(strtolower("location: "."/mbook/public/index.php"."/index/user/login"));
            exit();
        }
        $bigtype = new Bigtype();
    	$data1 = $bigtype->field('b_id,b_name')->select();
        $this->assign('bb',$data1);

        $data2=$bigtype->alias('a')->join('tb_smalltype b','a.b_id = b.b_id')->select();
        $this->assign('ss',$data2);

        return $this->fetch();
    }


    public function booklist(){
        if (!session('?ext_user')) {
            header(strtolower("location: "."/mbook/public/index.php"."/index/user/login"));
            exit();
        }
		$book=new \app\index\model\Book();
		$data= $book->where('s_id', input('get.sid'))->paginate(10,false,['query' => ['sid'=>input('get.sid')]]);
		$page = $data->render();
		$this->assign('blist',$data);
        $this->assign('page', $page);

		return $this->fetch();
	}

    public function book(){
        if (!session('?ext_user')) {
            header(strtolower("location: "."/mbook/public/index.php"."/index/user/login"));
            exit();
        }
        $book=new \app\index\model\Book();
        $data= $book->where('book_id', input('get.book_id'))->find();
        $this->assign('book',$data);
        return $this->fetch();
    }




}