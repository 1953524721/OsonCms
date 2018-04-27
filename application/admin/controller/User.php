<?php
namespace app\admin\controller;
use  app\admin\model\UserModel;
use  think\Controller;
use  think\Session;

class User  extends  Com{

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
        $this->userId  =  Session::get("user_info")['user_id'];
        $this->Model   =   new UserModel();
    }
    /*
     * 展示页面
     *
     * */
    public function showUser(){

        $UserArr =  $this->Model->getUser();
        return view("/User/showUser",['data'=>$UserArr]);
    }
    /*
     * 添加用户
     *
     * */
    public function  addUser(){
        $addUsername   =    $this->xss(input("post.user_name"));
        $addUserpwd    =    $this->xss(input("post.user_pwd"));
        $retArr        =    array(
            "user_name"=>$addUsername,
            "user_pwd"=>md5($addUserpwd),
        );
        $res = $this->Model->addUser($retArr);
        if($res){
            $this->success("添加成功","User/showUser",'','1');
        }else{
            $this->error("添加失败","User/showUser",'','1');
        }
    }
    /*
     * ajax删除用户
     * */
    public function delUser(){
        $userId =  $this->xss(input("post.userId"));
        $res    =  $this->Model->delUser($userId);
        if($res){
            exit(json_encode(array("e"=>1,"m"=>'删除成功')));
        }else{
            exit(json_encode(array("e"=>2,"m"=>'删除失败')));
        }
    }
    /*
     * ajax冻结用户
     * */
    public function statuUser(){
        $id=  $this->xss(input("post.id"));
        $where=  $this->xss(input("post.where"));
        if($where==1){
            $where=0;
        }else{
            $where=1;
        }
        $res    =  $this->Model->statuUser($where,$id);
        if($res){
            exit(json_encode(array("e"=>1,"m"=>'修改成功')));
        }else{
            exit(json_encode(array("e"=>2,"m"=>'修改失败')));
        }

    }
    public function errorUser(){
        $id=  $this->xss(input("post.id"));
        $where=  $this->xss(input("post.where"));
        if($where==0){
            $where=3;
        }else{
            $where=0;
        }
        $res    =  $this->Model->errorUser($where,$id);
        if($res){
            exit(json_encode(array("e"=>1,"m"=>'修改成功')));
        }else{
            exit(json_encode(array("e"=>2,"m"=>'修改失败')));
        }
    }
}