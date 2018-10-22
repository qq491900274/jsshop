<?php
namespace app\mobile\controller;
use think\Controller;
use think\View;
use think\Request;
use think\Session;
use app\model\lib\Home;


class Index extends Controller
{	
	public function __construct(){
		parent::__construct();
		
		//判断用户是否登录
       
	}
		
    public function index(){
      $this->assign('name','ThinkPHP');
     
       return $this->fetch('index'); 
    }
    public function test()
    {
      $this->HelloWordModel =  new \app\index\model\HelloWord();
      $result = $this->HelloWordModel->hello('helloword');
      var_dump($result);
    }
}
