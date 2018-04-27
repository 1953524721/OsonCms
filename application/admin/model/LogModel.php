<?php
namespace app\admin\model;
use think\Model;
use think\Db;
class LogModel extends Model
{
    public $tableName = "oson_log";
    public function Select()
    {
        $res = Db::table($this->tableName)->select();
        return $res;
    }
}