<?php
namespace app\admin\model;
use think\Model;
use think\Db;
class RolePowerModel extends    Model{
    public $tableName = "oson_r_p";

    public function addRolePower($newArr){
        $res  =  Db::table($this->tableName)->insertAll($newArr);
        return $res;
    }
    public function getRolePower(){
        $res = Db::query("SELECT oson_r_p.addtime,oson_role.role_id,oson_role.role_name,oson_power.power_id,oson_power.power_name FROM oson_r_p INNER JOIN  oson_role  ON oson_r_p.role_id  = oson_role.role_id INNER JOIN  oson_power  ON oson_r_p.power_id  = oson_power.power_id ");
        return $res;
    }
    public function delRolePower($roleId,$powerId){
        $res =   Db::table($this->tableName)->where("role_id",$roleId)->where("power_id",$powerId)->delete();
        return $res;
    }
}

