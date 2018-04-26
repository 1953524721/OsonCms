<?php
namespace app\admin\controller;
use app\admin\model\ConfgModel;
use think\Controller;
use think\Db;
class Conf extends Controller
{
    /*
    *@刘柯
    *2018/04/26  9：17
    *配置展示
    */
    public function show()
    {
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
    public function update()
    {
        $model = new ConfgModel();
        $data  = $model->Find("1");
        $this->assign("data",$data);
        return $this->fetch("update");
    }

}