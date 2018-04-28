<?php
namespace app\admin\controller;
use app\admin\model\LogModel;
use think\Db;
use think\Controller;
class Log extends Controller
{
    /*
     * @刘柯
     * 2018/04/26 19:58
     * 日志展示
     */
    public function logShow()
    {
        $page   = $this->xss(input("get.page",1));
        $size   = 10;
        $offset = ($page-1)*$size;
        $sql1   = "SELECT count(*) as num FROM `oson_log` ";
        $count  = Db::query($sql1)['0']['num'];
        $sql2   = "SELECT * FROM `oson_log` ORDER BY log_time DESC LIMIT  $offset,$size";
        $data   = Db::query($sql2);
        $best   = ceil($count/$size);
        $last   = $page-1<1?1:$page-1;
        $next   = $page+1>$best?$best:$page+1;
        $this->assign("data",$data);
        $this->assign("best",$best);
        $this->assign("last",$last);
        $this->assign("next",$next);
        return view("logShow",["data"=>$data]);
//        $Model = new LogModel();
//        $data  = $Model->Select();
//        return view("logShow",["data"=>$data]);
    }
}


