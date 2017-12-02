<?php
namespace app\index\model;
use think\Model;

class User extends Model
{
	protected $auto = ['user_name'];
	protected $insert = ['user_logintimes' => 0];  

	protected function setUserNameAttr($value)
    {
        return strtolower($value);
    }

    public static function login($name, $password)
    {

        $where['user_email'] = $name;
        $where['user_pwd'] = md5($password);

        $user=User::where($where)->find();
        if ($user) {
            unset($user["password"]);
            session("ext_user", $user);
            return true;
        }else{
            return false;
        }
    }



    // 退出登录
    public static function logout(){
        session("ext_user", NULL);
        return [
            "code" => 0,
            "desc" => "退出成功"
        ];
    }

    // 查询一条数据
    public static function search($name){
        $where['user_email'] = $name;
        $user=User::where($where)->find();
        return $user;
        // dump($user['admin_password']);
    }

    //更改用户密码

    public static function updatepassword($name,$newpassword){
        $where['user_email'] = $name;
        $user=User::where($where)->update(['user_password' => md5($newpassword)]);
        if ($user) {
            return true;
        }else{
            return false;
        }
    }
}