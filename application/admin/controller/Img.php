<?php
namespace app\admin\controller;
use think\Controller;
use think\Session;
use think\Request;
use think\Db;
use think\File;
class Img extends Controller
{
    public function addImg()
    {
        return $this->fetch('img');
    }
    public function addImgDo()
    {
        $desc             = input("post.desc");
        $file             = request()->file('file');
        $file_name        = $this->upload($file);




        $arr['oson_path'] = $file_name;
        $arr['oson_desc'] = $desc;
        $arr['add_time']  = date("Y-m-d H:i:s");
        $res=DB::table("oson_img")->insert($arr);
        if($res)
        {
            $this->success('新增成功', 'Img/showimg');
        }
        else
        {
            $this->error('新增失败');
        }
    }
    public function upload($file)
    {
        if($file)
        {
            $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
            if($info)
            {
                return  $info->getSaveName();
            }
            else
            {
                echo $file->getError();
            }
        }
    }
    /*
     * @刘柯
     * 2018/04/26 20:47
     * 展示
     */
    public function showImg()
    {
        $page   = $this->xss(input("get.page",1));
        $size   = 5;
        $offset = ($page-1)*$size;
        $sql1   = "SELECT count(*) as num FROM `oson_img` ";
        $count  = Db::query($sql1)['0']['num'];
        $sql2   = "SELECT * FROM `oson_img` LIMIT $offset,$size";
        $data   = Db::query($sql2);
        $best   = ceil($count/$size);
        $last   = $page-1<1?1:$page-1;
        $next   = $page+1>$best?$best:$page+1;
        $this->assign("data",$data);
        $this->assign("best",$best);
        $this->assign("last",$last);
        $this->assign("next",$next);
//        $data=DB::table("oson_img")->select();
//        $this->assign('data',$data);
        return $this->fetch('showImg',["data"=>$data]);
    }
    /*
     * @刘柯
     * 2018/04/26 20:48
     */
    public function delImg()
    {
        $img_id=input("post.img_id");
        $rs=db('oson_img')->where(array('img_id'=>$img_id))->delete();
        if($rs)
        {
            echo 1;
        }
        else
        {
            echo 2;
        }
    }
    /*
     * @刘柯
     * 2018/04/26 20:47
     * 状态修改
     */
    public function upImg(){
        $img_id=input("post.img_id");
        $status=input("post.status");
        if($status==0){
            $data['img_status']=1;
            $rs=db('oson_img')->where(array('img_id'=>$img_id))->update($data);
            if($rs){
                echo 1;
            }else{
                echo 2;
            }
        }else{
            $data['img_status']=0;
            $rs=db('oson_img')->where(array('img_id'=>$img_id))->update($data);
            if($rs)
            {
                echo 1;
            }
            else
            {
                echo 2;
            }
        }
    }
}