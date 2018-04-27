<?php
namespace app\admin\controller;
use app\admin\model\LoginModel;
use think\Controller;
use think\Session;
use think\Db;
    class Login  extends Controller
{
        //加载此页面！
    public function index(){
        //渲染模板
        return     $this->fetch("Login/login");
    }
    public function loginDO(){
//        print_r(input("post."));die;
        //接值过滤
        $name =    $this->xss(input('post.name'));

        $pwd  =    $this->xss(input('post.pwd'));
        //实例化model
        $user =    new LoginModel();
//        print_r($user);die;
        $res  =    $user->getLogin($name);
//        print_r($res);die;

        //错误次数大于等于3提醒
        if($res['error_num']>=3||$res['user_status']==1){
            exit(json_encode(array("e"=>2,"m"=>'此账户已经被冻结,请联系管理员')));
        }
        //账户错误
        if(empty($res)){
            exit(json_encode(array("e"=>0,"m"=>'账号不存在')));
        }
        //密码错误 次数+1
        if(md5($pwd)!=$res['user_pwd']){
             Db::execute("update oson_user set error_num = error_num+1 where `user_name` ='$name'");
            exit(json_encode(array("e"=>1,"m"=>'密码错误')));
        }
        //登录成功，记入sessin。清空错误次数
        Db::execute("update oson_user set error_num = 0 where `user_name` ='$name'");
        $rbac = Db::query("SELECT * FROM oson_power WHERE power_id IN (SELECT power_id FROM oson_r_p WHERE role_id in(SELECT role_id FROM oson_u_r WHERE user_id='$res[user_id]' ))");
        foreach ($rbac as $key => $val){
            if(!empty($val['controller_name'])){
                $rbacarr[]=$val['controller_name'].'/'.$val['action_name'];
            }

        }
        Session::set('rbac',$rbacarr);
        Session::set('user_info',$res);
        exit(json_encode(array("e"=>4,"m"=>'登录成功')));
    }









































}
