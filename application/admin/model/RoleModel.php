<?php
namespace app\admin\model;
use think\Model;
use think\Db;
class RoleModel extends    Model{
    public $tableName = "oson_role";
    /*
     * 展示所有角色
     * */
    public function getRole(){
        $res = Db::table($this->tableName)->select();
        return $res;
    }
    /*
    * 添加角色
    * */
    public function addRole($arr){
        $res =   Db::table($this->tableName)->insert($arr);
        return $res;
    }
    /*
  * 删除角色
  * */
    public function delRole($roleId){
        $res =   Db::table($this->tableName)->where('role_id',$roleId)->delete();
        return $res;
    }


}

