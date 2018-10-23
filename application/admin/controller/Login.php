<?php
namespace app\admin\controller;
use think\Controller;
use think\View;
use think\Request;
use think\Session;

use \think\Db;

class Login extends Controller
{	
	public function __construct(){
		parent::__construct();
	}
	   //登陆页面
    public function index(){

    	$this->assign('name','123');
    	return $this->fetch('login'); 
    }

    //验证密码功能
     function getpwd(){
        $request = request()->post();
       
        $this->LoginModel =  new \app\admin\model\LoginModel();
        $val=$this->LoginModel->select('SHOP_USER','USER',"USER='{$request['user']}' AND PASSWORD='{$request['pwd']}'");

        if ($val) {
          //登陆成功保存session
          $_SESSION['admin']=$val[0]['USER'];
          return array('msg'=>'登陆成功！','state'=>'1');  
        }else{
          return array('msg'=>'登陆失败！','state'=>'2');
        }
    }
}
