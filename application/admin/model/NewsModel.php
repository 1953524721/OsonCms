<?php
namespace app\admin\model;
use think\Model;
use think\Db;
class NewsModel extends    Model{
    public $tableName = "oson_news";

    /*
     * 验证是否是超级管理
     * */
//    public function isAdmin($userid){
//
//    }

    /*
     * 展示所有用户
     * */
    public function getNews(){
        $res = Db::table($this->tableName)->select();
        return $res;
    }
//    /*
//     * 添加用户
//     * */
//    public function addUser($arr){
//       $res =   Db::table($this->tableName)->insert($arr);
//       return $res;
//    }
//    /*
//   * 删除用户
//   * */
    public function delNews($userId){
        $res =   Db::table($this->tableName)->where('news_id',$userId)->delete();
        return $res;
    }
    public function addNews($post){
        $res =   Db::table($this->tableName)->insert($post);
        return $res;
    }
//    /*
//     * 冻结用户
//     *
//     * */
    public function statuNews($where,$id){
        $res = Db::table($this->tableName)->where('news_id',$id)->update(['is_show' =>$where]);
        return $res;
    }
//    public function errorUser($where,$id){
//        $res = Db::table($this->tableName)->where('user_id',$id)->update(['error_num' =>$where]);
//        return $res;
//    }

}

