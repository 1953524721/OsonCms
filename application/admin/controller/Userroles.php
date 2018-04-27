<?php
namespace app\admin\controller;
use  app\admin\model\UserRoleModel;
use  app\admin\model\UserModel;
use  app\admin\model\RoleModel;
use  think\Controller;
use think\Db;
use  think\Session;

class Userroles  extends  Com{

    /*
     * 用户id
     * */
        public $userId;
        public $Model;
        public $User;
        public $Role;
    /*
     * 用户id通过构造赋值为全局
     * */
    public function __construct()
    {
        $this->userId  =  Session::get("user_info")['user_id'];
        $this->Model   =  new UserRoleModel();
        $this->User    =  new UserModel();
        $this->Role    =  new RoleModel();
    }
    /*
     * 展示页面
     * */
    public function addShow(){
        $UserArr =  $this->User->getUser();
        $RoleArr =  $this->Role->getRole();
        $data = array(
            "user"=>$UserArr,
            "role"=>$RoleArr
        );
//        print_r($data);die;
        return view("Userroles/addUserRole",["data"=>$data]);
    }

    public function addUserRole(){
        $userId = $this->xss(input("post.user_id"));
        $roleId = $_POST['role_id'];
        $res =   Db::query("SELECT role_id FROM oson_u_r WHERE `user_id`='$userId' ");
        $new = array();
        foreach ($res as $key=>$val){
           foreach ($val as $k=>$v){
               $new[] = $v;
           }
        }
        foreach ($roleId as $key=>$val){
            if(!in_array($val,$new)){
                $newArr[$key]['role_id'] = $val;
                $newArr[$key]['user_id'] = $userId;
                $newArr[$key]['addtime'] = date("Y-m-d H:i:s",time());
            }
        }
        $addRes  = $this->Model->addUserRole($newArr);
        if($addRes){
            $this->success("添加成功","Userroles/showUserRole");
        }else{
            $this->error("添加失败","Userroles/addShow");
        }
    }
    public function showUserRole(){
        $arrAll = $this->Model->getUserRole();
        return view("Userroles/showUserRole",["data"=>$arrAll]);
    }
    public function delUserRole(){
        $roleId =  $this->xss(input("post.roleId"));
        $userId =  $this->xss(input("post.userId"));
        $res    =  $this->Model->delUserRole($roleId,$userId);
        if($res){
            exit(json_encode(array("e"=>1,"m"=>'删除成功')));
        }else{
            exit(json_encode(array("e"=>2,"m"=>'删除失败')));
        }
    }


}