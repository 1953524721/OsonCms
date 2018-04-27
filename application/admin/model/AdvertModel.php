<?php
namespace app\admin\model;
use think\Model;
use think\Db;
class AdvertModel extends Model
{
    public $tableName = "oson_advert";
    public function Select()
    {
        $res = Db::table($this->tableName)->select();
        return $res;
    }
    public function Where($id)
    {
        $res = Db::table($this->tableName)->where("advert_id",$id)->find();
        return $res;
    }







}







