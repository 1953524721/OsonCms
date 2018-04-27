<?php
namespace app\admin\Controller;
use think\Controller;
use think\Model;
use think\Db;
use think\Session;
use think\Request;
class Com extends Controller
{
    public function _initialize()
    {
        $user_info=Session::get('user_info');
        if(empty($user_info)){
            $this->error("请先登录","Login/index",'','1');
        }
        $request=  \think\Request::instance();
        $controoler=$request->controller();
        $action=$request->action();
        $ac=$controoler.'/'.$action;
        $rbac=Session::get('rbac');


        if(!in_array($ac,$rbac)){
            $this->error("你没有权限","index/index",'','1');
        }

    }


}