<?php
namespace app\index\controller;
use think\Controller;
use think\Request;
use think\Db;
class Index extends Controller
{
    public function index()
    {
        $nav    = DB::query("SELECT * FROM oson_nav WHERE nav_status=1  ORDER BY nav_ord ASC");
        $config = DB::query("SELECT * FROM oson_config");
        $advert = DB::query("SELECT * FROM oson_advert");
        $link   = DB::query("SELECT * FROM oson_link");
        $lunbo  = DB::query("SELECT * FROM oson_img");
        // print_r($lunbo);die;
        $this->assign("nav",$nav);
        $this->assign("config",$config);
        $this->assign("advert",$advert);
        $this->assign("link",$link);
        $this->assign("lunbo",$lunbo);
        return $this->fetch('index');

     }

     public function about(){
         $nav=DB::query("SELECT * FROM oson_nav WHERE nav_status=1  ORDER BY nav_ord ASC");
         $info=DB::query("SELECT * FROM oson_about");
         // print_r($info);die;
         $this->assign("nav",$nav);
         $this->assign("info",$info);
        return $this->fetch('about');
     }
     public function contact(){
         $nav=DB::query("SELECT * FROM oson_nav WHERE nav_status=1  ORDER BY nav_ord ASC");
         $this->assign("nav",$nav);
        return $this->fetch('contact');
     }
     public function join(){
         $nav=DB::query("SELECT * FROM oson_nav WHERE nav_status=1  ORDER BY nav_ord ASC");
         $this->assign("nav",$nav);
        return $this->fetch('join');
     }
     public function message(){
         $nav=DB::query("SELECT * FROM oson_nav WHERE nav_status=1  ORDER BY nav_ord ASC");
         $this->assign("nav",$nav);
        return $this->fetch('message');
     }
     public function messageDo(){
        $msg_data = input('post.');
        // print_r($msg_data);die();
        $msg_title = $this->xss($msg_data['msg_title']);
        $msg_user = $this->xss($msg_data['msg_user']);
        $msg_tel = $this->xss($msg_data['msg_tel']);
        $msg_email = $this->xss($msg_data['msg_email']);
        $msg_info = $this->xss($msg_data['msg_info']);
        // print_r($msg_data);die;
        $msg_time = date("Y-m-d H:i:s");
        // print_r($user_ip);die;
        // $sql = "INSERT INTO `oson_message`(`msg_title`, `msg_user`, `msg_tel`, `msg_email`, `msg_time`, `msg_info`) VALUES ('$msg_title, '$msg_user', '$msg_tel', '$msg_email', '$msg_time', '$msg_info')";
        // // echo $sql;die;
        // $ret = Db::execute($sql);

        $msg_arr = array(
           "msg_title"=>$msg_title,
           "msg_user"=>$msg_user,
           "msg_tel"=>$msg_tel,
           "msg_email"=>$msg_email,
           "msg_time"=>$msg_time,
           "msg_info"=>$msg_info

            );
        $ret = Db::table("oson_message")->insert($msg_arr);
        if ($ret) {
            $this->success("留言发布成功");
        }else{
            echo "<script>alert('啊哦~留言失败再给小欧一次机会再留一次言吧');</script>";
        }
}
     public function new_info(){
         $nav=DB::query("SELECT * FROM oson_nav WHERE nav_status=1  ORDER BY nav_ord ASC");
         $this->assign("nav",$nav);
        return $this->fetch('new_info');
     }
     public function new_list(){
         $nav=DB::query("SELECT * FROM oson_nav WHERE nav_status=1  ORDER BY nav_ord ASC");
         $this->assign("nav",$nav);
        return $this->fetch('new_list');
     }
     public function product_list(){
         $nav=DB::query("SELECT * FROM oson_nav WHERE nav_status=1  ORDER BY nav_ord ASC");
         $this->assign("nav",$nav);
        return $this->fetch('product_list');
     }
     public function product_info(){
         $nav=DB::query("SELECT * FROM oson_nav WHERE nav_status=1  ORDER BY nav_ord ASC");
         $this->assign("nav",$nav);
        return $this->fetch('product_info');
     }

}
