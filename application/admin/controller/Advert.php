<?php
namespace app\admin\controller;
use app\admin\model\Advertmodel;
use think\Controller;
class Advert extends Controller
{
    public function add()
    {
        return $this->fetch("advert");
    }
    

}