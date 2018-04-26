<?php
namespace app\admin\controller;
use app\admin\model\ConfgModel;
use think\Controller;
use think\Session;
use think\Db;
class Conf extends Controller
{
    /*
    *@宋守一
    *2018/04/26  9：17
    *配置展示
    */
    public function show(){
        $model = new ConfgModel();
        $data  = $model->Find("1");
        $this->assign("data",$data);
        return $this->fetch("show");
    }
    /*
     * @刘柯
     * 2018/04/16 16:19
     * 渲染修改页面
     */
    public function update(){
        $model = new ConfgModel();
        $data  = $model->Find("1");
        $logArr =  array(
            "log_name"=>"修改网站配置",
            "log_ip"=>$_SERVER['SERVER_ADDR'],
            "log_time"=>date("Y-m-d H:i:s",time()),
            "user_name"=>session::get("user_info")['user_name']?session::get("user_info")['user_name']:"测试组",
        );
        $model->logAdd($logArr);
        $this->assign("data",$data);
        return $this->fetch("update");

    }


}