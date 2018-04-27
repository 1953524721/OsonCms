<?php
namespace app\admin\model;
use think\Model;
use think\Db;
class UserRoleModel extends    Model{
    public $tableName = "oson_u_r";

    public function addUserRole($newArr){
        $res  =  Db::table($this->tableName)->insertAll($newArr);
        return $res;
    }
    public function getUserRole(){
        $res = Db::query("SELECT oson_u_r.addtime,oson_user.user_name,oson_user.user_id,oson_role.role_id,oson_role.role_name FROM oson_u_r  INNER JOIN oson_user on oson_u_r.user_id  = oson_user.user_id INNER JOIN oson_role on oson_u_r.role_id  = oson_role.role_id");
        return $res;
    }
    public function delUserRole($roleId,$userId){
        $res =   Db::table($this->tableName)->where("role_id",$roleId)->where("user_id",$userId)->delete();
        return $res;
    }

}

