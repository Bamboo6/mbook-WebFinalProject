<?php
namespace app\index\controller;

use function Sodium\increment;
use think\Controller;
use think\Db;
use think\View;
use think\Input;
use Captcha;

class User extends Controller
{
	//显示注册页面
	public function reg(){		
		return $this->fetch();
	}

    public function info(){
        if (!session('?ext_user')) {
            header(strtolower("location: "."/mbook/public/index.php"."/index/user/login"));
            exit();
        }
        return $this->fetch();
    }

    public function login(){
        $view = new View();
        return $view->fetch('login');
    }

    public function forgotpsw(){
        return $this->fetch();
    }

    public function findpsw(){
        return $this->fetch();
    }

    public function newpsw(){
        return $this->fetch();
    }

    public function insert(){
		$u=new \app\index\model\User();
		$username=\think\Request::instance()->post('username'); // 获取某个post变量username
        $truename=input('post.truename');
        $qq=input('post.qq');
        $tel=input('post.tel');
        $address=input('post.address');
		$password=input('post.password');
		$password1=input('post.repass');
		$sex= input('post.sex'); //性别
		$email=input('post.email');
		$question=input('post.question');
		$answer=input('post.answer');
		if (md5($password)==md5($password1)){
			$sql=$u->where('user_name',$username)->find();
			if($sql){
				$this->error("<h1>该用户已存在</h1>","index/user/reg");
			}else{
                $data['user_truename']=$truename;
                $data['user_qq']=$qq;
                $data['user_address']=$address;
                $data['user_tel']=$tel;
				$data['user_name']=$username;
				$data['user_pwd']=md5($password);
				$data['user_sex']=$sex;
				$data['user_email']=$email;
				$data['user_question']=$question;
				$data['user_answer']=$answer;
				$u->insert($data); // 插入数据库
				$this->success("<h1>注册成功</h1>","index/user/login");
			}
		}else{
            $this->error("<h1>两次输入的密码不吻合</h1>","index/user/reg");
		}		
    }

    public function insert2(){
        $data['user_name']=\think\Request::instance()->post('username'); // 获取某个post变量username
        $data['user_truename']=input('post.truename');
        $data['user_qq']=input('post.qq');
        $data['user_address']=input('post.address');
        $data['user_pwd']=input('post.password');
        $data['repass']=input('post.repass');
        $data['user_sex']=input('post.sex'); //性别
        $data['user_email']=input('post.email');

        $validate = \think\Loader::validate('User');
        if(!$validate->check($data)){
            //echo '<h1>'.$validate->getError().' 点击此处 <a href="javascript:history.back(-1);">返回</a></h1>';
            $this->error($validate->getError());
        }

        $u=new \app\index\model\User();
        $u->user_name=\think\Request::instance()->post('username');
        $u->user_pwd=md5(input('post.password'));
        $u->user_sex=input('post.gender'); //性别
        $u->user_email=input('post.email');
        $u->save();
        $this->success("<h1>注册成功</h1>","index/user/login");
    }

    public function getuseremail(){
        $view = new View();
        $u=new \app\index\model\User();
        $email=\think\Request::instance()->post('email'); // email
        $sql=$u->where('user_email',$email)->find();
        if($sql){
            $result = Db::query('select user_question from tb_user where user_email=?',[$email]);
            //$string=implode($result);
            //$String = (string)$result;
            //var_dump($string);
            //$this->assign('result',$result);
            //$view->name = 'thinkphp';
            $view->email = $email;
            $view->result = $result;
            return $view->fetch('user/findpsw');
        }else{
            $this->error("<h1>此邮箱未绑定用户</h1>","index/user/login");
        }
    }

    public function changepsw(){
        $view = new View();
        $email=\think\Request::instance()->post('email'); // email
        $answer=\think\Request::instance()->post('answer'); //answer
        $question=\think\Request::instance()->post('question'); //$question
        $sql = Db::query('select user_answer from tb_user where user_question=?',[$question]);
        $string = $sql[0]['user_answer'];
        /*var_dump($question);
        var_dump($answer);
        var_dump($sql);*/
        if ($answer == $string){
            $view->email = $email;
            return $view->fetch('user/newpsw');
            $this->success("<h1>验证成功</h1>");
        }else{
            $this->error("<h1>身份验证失败</h1>","index/user/login");
        }

    }

    public function newp(){
        $view = new View();
        $email=\think\Request::instance()->post('email'); // email
        $psw=\think\Request::instance()->post('psw'); //password
        $npsw=\think\Request::instance()->post('npsw'); //newpassword
        $psw=md5($psw);
        $npsw=md5($npsw);
//        $sql = Db::query('UPDATE tb_user SET user_pwd = ? WHERE user_email = ?',[$psw][$email]);
//        var_dump($sql);
        if ($psw == $npsw){
            $sql = Db::execute('UPDATE tb_user SET user_pwd = ? WHERE user_email = ?',[$psw,$email]);
            /*$u=new \app\index\model\User();
            $u->user_pwd=(input('post.psw'));
            $u->save();*/
            /*$sql = Db::table('tb_user')
                    ->where('user_email:email',['email'=>$email])
                    ->update(['user_pwd' => $psw]);*/
            /*$u=new \app\index\model\User();
            $u->save(['user_pwd' => $psw],['user_email' => $email]);*/
            $this->success("<h1>修改成功</h1>","index/user/login");
        }else{
            $this->error("<h1>两次输入的密码吻合</h1>","index/user/login");
        }
    }

    public function logining()
    {
        $view = new View();
        $name = input('request.email');
        $password  = input('request.password');
        $data = input('request.captcha');
        dump($data);
        if(!captcha_check($data)){
            //验证失败
            return $this->error("验证码错误");
        }


        $check=\app\index\model\User::login($name, $password);
        if ($check) {
            // header(strtolower("location:"));
            header(strtolower("location: "."/mbook/public/index.php"."/index/Index/index.html"));
            exit();
        }

        return $view->fetch('logining');
    }

    function captcha_img($id = "")
    {
        return '<img src="' . captcha_src($id) . '" alt="captcha" />';
    }

    public function logindo()
    {
        $u = new \app\index\model\User();
        $email = \think\Request::instance()->post('email'); // email
        $psw = \think\Request::instance()->post('password'); //password
        $check = $u->where('user_email', $email)->find();
        if ($check) {
            $sql = Db::query('select user_pwd from tb_user where user_email=?', [$email]);
            $psw = md5($psw);
            if ($sql == $psw) {
                session("email",$email);
                $this->success("<h1>登录成功</h1>", "index");
            }
        } else {
            $this->error("<h1>此邮箱未绑定用户</h1>", "index/user/login");
        }

    }

    // 退出登录
    public function logout(){
        \app\index\model\User::logout();

        if (!session('?ext_user')) {
            header(strtolower("location: ".config("web_root")."/index/user/login"));
            exit();
        }
        header(strtolower("location:login"));
        return NULL;
    }

}