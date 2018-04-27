<?php
namespace app\admin\controller;
use  app\admin\model\NewsModel;
use  think\Controller;
use  think\Session;
use  think\Db;
class News  extends  Com{

    /*
     * 用户id
     * */
        public $userId;
        public $Model;
    /*
     * 用户id通过构造赋值为全局
     * */


    public function __construct(){
        $this->userId  =  Session::get("user_info")['user_id'];
        $this->Model   =   new NewsModel();
    }
    /*
     * 展示页面
     *
     * */

    public function addNews(){
        return view("News/add");
    }
    public function addNewsDo(){
       $post = input("post.");
       foreach ($post as $key=>$Val){
           $post[$key]=  $this->xss($Val);
       }
        $res = $this->Model->addNews($post);
        $logArr =  array(
            "log_name"=>"添加新闻",
            "log_ip"=>$_SERVER['SERVER_ADDR'],
            "log_time"=>date("Y-m-d H:i:s",time()),
            "user_name"=>session::get("user_info")['user_name']
        );
        Db::table("oson_log")->insert($logArr);
        if($res){
            $this->success("添加成功","News/showNews",'','1');
        }else{
            $this->error("添加失败","News/addNews",'','1');
        }

    }
    public function showNews(){
        $NewsArr =  $this->Model->getNews();
        return view("/News/showNews",['data'=>$NewsArr]);
    }


    public function delNews(){
        $userId =  $this->xss(input("post.userId"));
//        print_r($userId);die
        $res    =  $this->Model->delNews($userId);
        $logArr =  array(
            "log_name"=>"删除新闻",
            "log_ip"=>$_SERVER['SERVER_ADDR'],
            "log_time"=>date("Y-m-d H:i:s",time()),
            "user_name"=>session::get("user_info")['user_name']
        );
        Db::table("oson_log")->insert($logArr);
        if($res){
            exit(json_encode(array("e"=>1,"m"=>'删除成功')));
        }else{
            exit(json_encode(array("e"=>2,"m"=>'删除失败')));
        }
    }

    public function statuNews(){
//        print_r(input("post."));die;
        $id=  $this->xss(input("post.id"));
        $where=  $this->xss(input("post.where"));
        if($where==1){
            $where=0;
        }else{
            $where=1;
        }
        $logArr =  array(
            "log_name"=>"新闻状态修改",
            "log_ip"=>$_SERVER['SERVER_ADDR'],
            "log_time"=>date("Y-m-d H:i:s",time()),
            "user_name"=>session::get("user_info")['user_name']
        );
        Db::table("oson_log")->insert($logArr);
        $res    =  $this->Model->statuNews($where,$id);
        if($res){
            exit(json_encode(array("e"=>1,"m"=>'修改成功')));
        }else{
            exit(json_encode(array("e"=>2,"m"=>'修改失败')));
        }

    }
}