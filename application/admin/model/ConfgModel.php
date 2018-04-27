<?php
namespace app\admin\model;
use think\Model;
use think\Db;
class ConfgModel extends Model
{
    public $tableName = "oson_config";
    public function Find(){
        $res = Db::table($this->tableName)->find();
        return $res;
    }
    public function logAdd($logArr){
        $res = Db::table("oson_log")->insert($logArr);
        return $res;
    }
    public function upStatu($where){
        $up = array("is_show"=>$where);
        $id = array("config_id"=>1);
        $res = Db::table($this->tableName)->where($id)->update($up);
        return $res;
    }
    public function upload_ok($post){
        $id = array("config_id"=>1);
        $res = Db::table($this->tableName)->where($id)->update($post);
        return $res;
    }
}