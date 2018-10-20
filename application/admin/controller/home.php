<?php
namespace app\model\controller;
use think\Controller;
use think\View;
use think\Request;
use think\Session;
use app\index\lib\Home;//deng xia


class Index extends Home
{	
    public function index(){
      //$this->assign('name','ThinkPHP');
       return $this->fetch('index'); 
    }
    public function test()
    {
      $this->HelloWordModel =  new \app\index\model\HelloWord();
      $result = $this->HelloWordModel->hello('helloword');
     
    }
}
