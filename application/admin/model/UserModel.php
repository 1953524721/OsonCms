<?php
namespace app\admin\model;
use think\Model;
use think\Db;
class UserModel extends    Model{
    public $tableName = "oson_user";

    /*
     * 验证是否是超级管理
     * */
//    public function isAdmin($userid){
//
//    }

    /*
     * 展示所有用户
     * */
    public function getUser(){
        $res = Db::table($this->tableName)->where("is_boss",0)->select();
        return $res;
    }
    /*
     * 添加用户
     * */
    public function addUser($arr){
       $res =   Db::table($this->tableName)->insert($arr);
       return $res;
    }
    /*
   * 删除用户
   * */
    public function delUser($userId){
        $res =   Db::table($this->tableName)->where('user_id',$userId)->delete();
        return $res;
    }
    /*
     * 冻结用户
     *
     * */
    public function statuUser($where,$id){
        $res = Db::table($this->tableName)->where('user_id',$id)->update(['user_status' =>$where]);
        return $res;
    }
    public function errorUser($where,$id){
        $res = Db::table($this->tableName)->where('user_id',$id)->update(['error_num' =>$where]);
        return $res;
    }

}

