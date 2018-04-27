<?php
namespace app\admin\controller;
use app\admin\model\RoleModel;
use app\admin\model\PowerModel;
use app\admin\model\RolePowerModel;
use  think\Controller;
use think\Db;
use  think\Session;
class Rolepower  extends  Com{

    /*
     * 用户id
     * */
        public $userId;
        public $Model;
        public $Role;
        public $Power;
    /*
     * 用户id通过构造赋值为全局
     * */
    public function __construct()
    {
        $this->userId  =  Session::get("user_info")['user_id'];
        $this->Model   =  new   RolePowerModel();
        $this->Role    =  new   RoleModel();
        $this->Power   =  new   PowerModel();
    }
    public function addRolePower(){
        $RoleArr  =  $this->Role->getRole();
        $PowerArr =  $this->Power->getPower();
        $data     =  array(
            "role"=>$RoleArr,
            "power"=>$PowerArr
        );
        return view("RolePower/addRolePower",['data'=>$data]);
    }
    public function addPowerDo(){
         $roleId    = $this->xss(input("post.role_id"));
         $powerId   = $_POST['power_id'];
         $res =   Db::query("SELECT power_id FROM oson_r_p WHERE `role_id`='$roleId' ");
         $new = array();
         foreach ($res as $key=>$val){
            foreach ($val as $k=>$v){
                $new[] = $v;
            }
         }
        foreach ($powerId as $key=>$val){
            if(!in_array($val,$new)){
                $newArr[$key]['role_id'] = $roleId;
                $newArr[$key]['power_id'] = $val;
                $newArr[$key]['addtime'] = date("Y-m-d H:i:s",time());
            }
        }

        $addRes  = $this->Model->addRolePower($newArr);
        if($addRes){
            $this->success("添加成功","Rolepower/showRolepower");
        }else{
            $this->error("添加失败","Rolepower/addRolePower");
        }
    }
    public function showRolepower(){
        $arrAll = $this->Model->getRolePower();
        return view("RolePower/showRolePower",["data"=>$arrAll]);

    }
    public function delRolePower(){
        $roleId =  $this->xss(input("post.roleId"));
        $powerId=  $this->xss(input("post.powerId"));
        $res    =  $this->Model->delRolePower($roleId,$powerId);
        if($res){
            exit(json_encode(array("e"=>1,"m"=>'删除成功')));
        }else{
            exit(json_encode(array("e"=>2,"m"=>'删除失败')));
        }

    }



}