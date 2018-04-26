<?php
namespace app\admin\model;
use think\Model;
use think\Db;
class ConfgModel extends Model
{
    public $tableName = "oson_config";
    public function Find($str = ""){
        $res = Db::table($this->tableName)->where("is_show",$str)->find();
        return $res;
    }
    public function logAdd($logArr){
        $res = Db::table("oson_log")->insert($logArr);
        return $res;
    }
}