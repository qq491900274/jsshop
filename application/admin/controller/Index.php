<?php
namespace app\index\controller;
use think\Controller;
use think\View;
use think\Request;
use think\Session;
use app\index\lib\Home;


class Index extends Controller
{	
	public function __construct(){
		parent::__construct();
<<<<<<< HEAD
	    //判断用户是否登录
    echo url('mobile/cart/index');die;
        if(empty($_SESSION['user'])){
        	$this->error('请登录！',url('Login/index'));
        }
=======
		
		//判断用户是否登录
      if(empty($_SESSION['user'])){
      	$this->error('请登录！',"HTTP://{$_SERVER['SERVER_NAME']}/js-shop?s=admin/Login/index");
      }
>>>>>>> 9e4beee3b948e6cccde38064656637d5d45752b2
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
