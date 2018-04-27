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
     * @宋守一
     * 2018/04/16 16:19
     * 渲染修改页面
     */
    public function update(){
        $model = new ConfgModel();
        $data  = $model->Find("1");
        $this->assign("data",$data);
        return $this->fetch("update");

    }
    /*
    * @宋守一
    * 2018/04/16 16:19
    * 修改网站
    */
    public function statu(){
        $where = $this->xss(input("post.where"));
        $model = new ConfgModel();
        $logArr =  array(
            "log_name"=>"开启或关闭网站",
            "log_ip"=>$_SERVER['SERVER_ADDR'],
            "log_time"=>date("Y-m-d H:i:s",time()),
            "user_name"=>session::get("user_info")['user_name']
        );
        $model->logAdd($logArr);
        $data  = $model->upStatu($where);
        if($data&&$model){
           exit(json_encode(array("e"=>1,"m"=>"修改成功")));
        }else{
            exit(json_encode(array("e"=>0,"m"=>"修改失败")));
        }

    }
    /*
 * @宋守一
 * 2018/04/16 16:19
 * 修改网站Do
 */
    public function upload_ok(){
        $post = input("post.");
        foreach ($post as $k =>$v){
             $post[$k] =  $this->xss($v);
        }
        $file =  request()->file("config_img");
        $img = $this->upload($file);
        $post['config_img'] = $img;
//        print_r($post);die;
        $logArr =  array(
            "log_name"=>"修改网站配置",
            "log_ip"=>$_SERVER['SERVER_ADDR'],
            "log_time"=>date("Y-m-d H:i:s",time()),
            "user_name"=>session::get("user_info")['user_name']?session::get("user_info")['user_name']:"测试组",
        );
        $model = new ConfgModel();
        $model->logAdd($logArr);
        $resUp = $model->upload_ok($post);
        if($resUp){
            $this->success("修改成功","Conf/show",'',1);
        }else{
            $this->success("修改失败","Conf/update",'',1);
        }

    }
    public function upload($file){
        if($file){
            $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
            if($info){
                return $info->getSaveName();
            }else{
                echo $file->getError();
            }
        }
    }




}