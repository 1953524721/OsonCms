<?php
namespace app\admin\controller;
use  app\admin\model\PowerModel;
use  think\Controller;
use  think\Session;
use think\Db;
class Power  extends  Com{
        public $userId;

        public $Model;

        public function __construct(){
            $this->Model   =   new PowerModel();
        }
        public function showPower(){
            $arr     =  $this->Model->getPower();
            $digui   =  $this->getSontree($arr);

            return  view("Power/showPower",["data"=>$digui]);
        }
        public function addPower(){
        $addRolename       =    $this->xss(input("post.power_name"));
        $controller_name   =    $this->xss(input("post.controller_name"));
        $action_name       =    $this->xss(input("post.action_name"));
        $parent_id         =    $this->xss(input("post.parent_id"));
        $arr =  array(
            "power_name"=>$addRolename,
            "controller_name"=>$controller_name,
            "action_name"=>$action_name,
            "parent_id"=>$parent_id
        );
        $res = $this->Model->addPower($arr);
        if($res){
            $this->success("添加成功","Power/showPower",'','1');
        }else{
            $this->error("添加失败","Power/showPower",'','1');
        }
    }
    public function delPower(){
        $PowerId =  $this->xss(input("post.PowerId"));
        $res = Db::table("oson_power")->where("parent_id",$PowerId)->select();
        if(!empty($res)){
            exit(json_encode(array("e"=>3,"m"=>'请先删除当前子集权限')));
        }
        $res    =  $this->Model->delPower($PowerId);
        if($res){
            exit(json_encode(array("e"=>1,"m"=>'删除成功')));
        }else{
            exit(json_encode(array("e"=>2,"m"=>'删除失败')));
        }
    }






















        function getSontree($data,$parent_id=0,$f=0){
            static  $arr=array();
            foreach ($data as $key => $value) {
                if($value['parent_id']==$parent_id){
                    $arr[$key]=$value;
                    $arr[$key]['f']= $f;
                    $this->getSontree($data,$value['power_id'],$f+1);
                }
        }
        return $arr;
    }
































}