<?php
namespace app\admin\controller;
use think\Controller;
class Nav extends Controller
{
    public function index()
    {
    	return $this->fetch('index');
        
    }
}
