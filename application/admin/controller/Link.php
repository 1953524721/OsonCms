<?php
/**
 * @Author: Marte
 * @Date:   2018-04-20 16:32:31
 * @Last Modified by:   Marte
 * @Last Modified time: 2018-04-20 20:44:29
 */
namespace app\admin\controller;
use app\admin\model\LinkModel;
use think\Controller;
use think\Request;
use think\Db;
class Link extends Controller
{

     public $Model;
     public function __construct(){
        $this->Model  = new LinkModel();
     }
   public function demolink(){
     return view("linkAdd");
   }
   public function addlink(){
      $link_data = input('post.');
        // print_r($link_data);die;
        $sql = "INSERT INTO `oson_link` (`link_name`, `link_url`) VALUES ('".$link_data['link_name']."', '".$link_data['link_url']."')";
        $ret = Db::execute($sql);
        if ($ret) {
            $this->success("添加友情链接成功",url('link/showlink'));
        }else{
            echo "<script>alert('添加失败');";
        }
   }

   public function showlink(){

         $data  = $this->Model->Select("oson_link");
         // print_r($data);die;
         // $this->assign("data",$data);
        return view("showlink",['data'=>$data]);
   }

   public function delLink(){
        $link_id=input("post.link_id");
        $rs=db('oson_link')->where(array('link_id'=>$link_id))->delete();
        if($rs){
            echo 1;
        }else{
            echo 2;
        }
    }

}