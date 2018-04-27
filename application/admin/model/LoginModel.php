<?php
namespace app\admin\model;
use think\Model;
use think\Db;
class LoginModel extends    Model{
    public $tableName = "oson_user";

    public function getLogin($str){
//        return $str;
        $res =   Db::table($this->tableName)->where('user_name',$str)->find();
        return $res;
    }

}

