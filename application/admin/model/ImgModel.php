<?php
namespace app\admin\model;
use think\Model;
use think\Db;
class ImgModel extends Model
{
    public $tableName = "oson_img";
    public function Select()
    {
        $res = Db::table($this->tableName)->select();
    }
}