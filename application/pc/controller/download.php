<?php
namespace app\pc\controller;
use think\Controller;
use think\View;
use think\Request;
use think\Session;



class Index extends pc_controller
{	
	public function __construct(){
		parent::__construct();
		
		//判断用户是否登录
        // if(empty($_SESSION['user'])){
        // 	$this->error('请登录！',"HTTP://{$_SERVER['SERVER_NAME']}/tp?s=index/Login/index");
        // }
	}
		
    public function index(){
      //$this->assign('name','ThinkPHP');
      $home=new Home();
      $home->hell();
       return $this->fetch('index'); 
    }
    public function test()
    {
      $this->HelloWordModel =  new \app\index\model\HelloWord();
      $result = $this->HelloWordModel->hello('helloword');
      var_dump($result);
    }
}
