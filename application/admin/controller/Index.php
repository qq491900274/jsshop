<?php
namespace app\admin\controller;
use think\Controller;
use think\View;
use think\Request;
use think\Session;
use app\index\lib\Home;
use \think\Db;

class Index extends Controller
{	
	public function __construct(){
		parent::__construct();

	    //判断用户是否登录
    echo url('mobile/cart/index');die;
        if(empty($_SESSION['user'])){
        	$this->error('请登录！',url('Login/index'));
        }

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

     public function activity(){
      $request=request()->post();
      if (empty($request)) {
        return $this->fetch('activity');
      }
      

      //返回信息
      return Db::table('SHOP_ACTIVITY')->select();
    }
}
