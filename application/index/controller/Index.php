<?php
namespace app\admin\controller;


class Index
{
    public function index()
    {

        $ip =  $_SERVER['SERVER_ADDR'];
        if($ip!='127.0.0.1'){
            die("<script>alert('抱歉,本网站暂不对外开放')</script>");
        }

     }

}
