<?php
namespace app\admin\controller;
use app\admin\model\RoleModel;
use think\Session;
use think\Db;
    class Role  extends Com
    {
      /*
      * 用户id
      * */
        public $userId;
        public $Model;
        /*
         * 用户id通过构造赋值为全局
         * */
        public function __construct()
        {
//            $this->userId  =  Session::get("user_info")['user_id'];
            $this->Model   =   new RoleModel();
        }
        public function showRole(){
            $roleArr       = $this->Model->getRole();
            return view("Role/showRole",["data"=>$roleArr]);

        }
        public function addRole(){
            $addRolename   =    $this->xss(input("post.role_name"));
//            print_r($addRolename);die;
            $arr =  array(
                "role_name"=>$addRolename
            );
            $res = $this->Model->addRole($arr);
            if($res){
                $this->success("添加成功","Role/showRole",'','1');
            }else{
                $this->error("添加失败","User/showRole",'','1');
            }
        }
        public function delRole(){
            $roleId =  $this->xss(input("post.roleId"));
//            print_r($roleId);die;
            $res    =  $this->Model->delRole($roleId);
            if($res){
                exit(json_encode(array("e"=>1,"m"=>'删除成功')));
            }else{
                exit(json_encode(array("e"=>2,"m"=>'删除失败')));
            }
        }





    }




