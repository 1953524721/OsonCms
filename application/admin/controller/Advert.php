<?php
namespace app\admin\controller;
use app\admin\model\AdvertModel;
use think\Db;
use think\Session;
use think\File;
use think\Request;
use think\Controller;
class Advert extends Controller
{
    public function add()
    {
        return $this->fetch("advert");
    }
    public function ins()
    {
        $file                 = request()->file('file');
//        print_r($file);die();
        $fileName             = date("Ymd") . "/" . $this->file($file);
        $data                 = input('post.');
        $arr['advert_name']   = $this->xss($data['name']);
        $arr['advert_url']    = "http://" . $data['url'];
        $arr['advert_brief']  = $this->xss($data['brief']);
        $arr['start_time']    = $this->xss($data['start_time']);
        $arr['end_time']      = $this->xss($data['end_time']);
        $arr['advert_img']    = $fileName;
//        $rest['user_name']    = $session = Session::get('user_info')['user_id'];
        $rest['user_name']    = "刘柯";
        $rest['log_time']     = date("Y-m-d H:i:s");
        $rest['log_ip']       = $_SERVER['SERVER_ADDR'];
        $rest['log_name']     = "添加广告";

        $res = Db::table("oson_advert")->insert($arr);
        $log = Db::table("oson_log")->insert($rest);
        if($res && $log)
        {
            $this->success("广告添加成功",url('advert/AdvertShow'));
        }
        else
        {
            $this->error();
        }

//        Db::startTrans();//事物开启
//        try
//        {
//            Db::table("oson_advert")->insert($arr);
//            Db::table("oson_log")->insert($rest);
//            Db::commit();//提交
//            $this->success("广告添加成功",url('advert/AdvertShow'));
//        }
//        catch( \Exception $exception)
//        {
//            Db::rollback();//回滚
//            $this->error();
//        }
    }

    /*
     * 文件上传操作
     * $info = public/uploads
    */
    public function file($file)
    {
        $error = $_FILES['file']['error'];
        if ($error)
        {
            echo "<script>alert('文件上传失败！');location.href='" . $_SERVER["HTTP_REFERER"] . "';</script>";
        }
        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
        if ($info)
        {
//            $fileName = $info->getFilename();
            $file = $info->getFilename();
            return $file;
        }
        else
        {
            $this->error($file->getError());
        }
    }
    /*
     * @刘柯
     * 2018/04/26 19:07
     * 广告展示
     */
    public function AdvertShow()
    {
        $page   = $this->xss(input("get.page",1));
        $size   = 5;
        $offset = ($page-1)*$size;
        $sql1   = "SELECT count(*) as num FROM `oson_advert` ";
        $count  = Db::query($sql1)['0']['num'];
        $sql2   = "SELECT * FROM `oson_advert` LIMIT $offset,$size";
        $data   = Db::query($sql2);
        $best   = ceil($count/$size);
        $last   = $page-1<1?1:$page-1;
        $next   = $page+1>$best?$best:$page+1;
        $this->assign("data",$data);
        $this->assign("best",$best);
        $this->assign("last",$last);
        $this->assign("next",$next);
//        $model  = new AdvertModel();
//        $data   = $model->select();
//        print_r($data);die();
        return view("advertShow",["data"=>$data]);
    }
    /*
     * @刘柯
     * 2018/04/17 9:30
     * 渲染修改
     */
    public function advertUp()
    {
        $Model = new AdvertModel();
        $id    = $this->xss(input("get.id"));
        $data  = $Model->Where($id);
        return view("advertUp",["data"=>$data]);
    }
    /*
     * @刘柯
     * 2018/04/27 9:37
     * 修改
     */
    public function up()
    {
        $file                 = request()->file('file');
        $fileName             = date("Ymd") . "/" . $this->file($file);
        $data                 = input('post.');
        $id                   = $data['id'];
        $arr['advert_name']   = $this->xss($data['name']);
        $arr['advert_url']    = "http://" . $data['url'];
        $arr['advert_brief']  = $this->xss($data['brief']);
        $arr['start_time']    = $this->xss($data['start_time']);
        $arr['end_time']      = $this->xss($data['end_time']);
        $arr['advert_img']    = $fileName;
//        $rest['user_name']    = $session = Session::get('user_info')['user_id'];
        $rest['user_name']    = "刘柯";
        $rest['log_time']     = date("Y-m-d H:i:s");
        $rest['log_ip']       = $_SERVER['SERVER_ADDR'];
        $rest['log_name']     = "修改广告"."$id";
        $res = Db::table("oson_advert")->where("advert_id",$id)->update($arr);
        $log = Db::table("oson_log")->insert($rest);
        if($res && $log)
        {
            $this->success("广告修改成功",url('advert/AdvertShow'));
        }
        else
        {
            $this->error();
        }
    }
}