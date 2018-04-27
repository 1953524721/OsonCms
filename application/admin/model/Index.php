<?php
namespace app\admin\model;
use think\Model;
use think\Db;
use think\Session;
class Index extends Model{
    public function selectAll(){
        $user_id=Session::get('user_info')['user_id'];
        return DB::query("SELECT * FROM oson_power WHERE power_id IN (SELECT power_id FROM oson_r_p WHERE role_id IN(SELECT role_id FROM oson_u_r WHERE user_id=$user_id))");
    }
    public function digui($data,$p=0){
        static $arr=array();
        foreach ($data as $key =>$val){
            if($val['parent_id']==$p){
                $arr[]=$val;
                $this->digui($data,$val['power_id']);
            }
        }
        return $arr;
    }
    function getSontree($data,$parent_id=0){
        $arr=array();
        foreach ($data as $key => $value) {
            if($value['parent_id']==$parent_id){
                $arr[$key]=$value;
                $arr[$key]['son']=$this->getSontree($data,$value['power_id']);
            }
        }
        return $arr;
    }
}