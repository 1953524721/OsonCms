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







}







