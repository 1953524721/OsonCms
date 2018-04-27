<?php
namespace app\admin\model;
use think\Model;
use think\Db;
class PowerModel extends    Model{
    public $tableName = "oson_power";


    public function getPower(){
        $res = Db::table($this->tableName)->select();
        return $res;
    }
//    /*
//     * 添加用户
//     * */
    public function addPower($arr){
       $res =   Db::table($this->tableName)->insert($arr);
       return $res;
    }
//    /*
//   * 删除用户
//   * */
    public function delPower($userId){
        $res =   Db::table($this->tableName)->where('power_id',$userId)->delete();
        return $res;
    }
//    /*
//     * 冻结用户
//     *
//     * */
//    public function statuUser($where,$id){
//        $res = Db::table($this->tableName)->where('user_id',$id)->update(['user_status' =>$where]);
//        return $res;
//    }
//    public function errorUser($where,$id){
//        $res = Db::table($this->tableName)->where('user_id',$id)->update(['error_num' =>$where]);
//        return $res;
//    }

}

