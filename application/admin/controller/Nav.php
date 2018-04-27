<?php
namespace app\admin\controller;
use think\Controller;
use think\Session;
use think\Db;
class Nav extends Controller
{
    public function index()
    {
    	return $this->fetch('index');
    }
    public function add(){
        $data=$_POST;
        $data['add_time']=date("Y-m-d H:i:s");
        //print_r($data);
        $res = DB::name('oson_nav')->insert($data);
        if($res){
            $arr=array(
                "log_name"=>"修改网站配置",
                "log_ip"=>$_SERVER['SERVER_ADDR'],
                "log_time"=>date("Y-m-d H:i:s",time()),
                "user_name"=>session::get("user_info")['user_name']?session::get("user_info")['user_name']:"测试组",
            );
            $ret=DB::name('oson_log')->insert($arr);
            if($ret){
                echo json_encode(array("e"=>1,"msg"=>"添加成功"));
            }else{
                echo json_encode(array("e"=>2,"msg"=>"添加失败"));
            }
        }else{
            echo json_encode(array("e"=>2,"msg"=>"添加失败"));
        }

    }
    public function show(){
        $page = input('get.page',1);
        $size=10;
        //$page=1;
        $offset=($page-1)*$size;
        $count=DB::query("SELECT COUNT(*) as num FROM oson_nav")[0]['num'];
        $best=ceil($count/$size);
        $data=DB::query("SELECT * FROM oson_nav LIMIT $offset,$size");
        $last=$page-1<1?1:$page-1;
        $next=$page+1>$best?$best:$page+1;
        //$log=DB::name("oson_log")->select();
        $this->assign('data',$data);
        $this->assign('best',$best);
        $this->assign('last',$last);
        $this->assign('next',$next);
        return $this->fetch();
    }
    public function update(){
         $data=$_POST;
         $arr[$data['zd']]=$data['name'];
         $ret=DB('oson_nav')->where(array('nav_id'=>$data['nav_id']))->update($arr);
         if($ret){
             echo json_encode(array("e"=>1));
         }else{
             echo json_encode(array("e"=>2));
         }
    }
    public function del(){
        $nav_id=$_POST['nav_id'];
        $ret=db('oson_nav')->where(array('nav_id'=>$nav_id))->delete();
        if($ret){
            echo json_encode(array("e"=>1));
        }else{
            echo json_encode(array("e"=>2));
        }
    }
}
