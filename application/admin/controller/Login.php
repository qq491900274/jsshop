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
    	return $this->fetch('login'); 
    }

    //验证密码功能
     function getpwd(){
        $request = request()->post();
       
        $this->LoginModel =  new \app\admin\model\LoginModel();
        $val=$this->LoginModel->select('SHOP_USER','USER,GNAME',"USER='{$request['user']}' AND PASSWORD='{$request['pwd']}'");
        if($val){
        	$actions = $this->LoginModel->select('SHOP_AUTH','AUTH',"NAME='{$val[0]['GNAME']}'");
        	if($val[0]['GNAME'] == 1){
	        	Session::set('admin',1);
	          	Session::set('actions',1);
	        }elseif($val[0]['GNAME'] == 2){
	        	Session::set('admin',2);
	          	Session::set('actions',2);
	        }else{
	        	Session::set('admin',$val[0]['USER']);
	          	Session::set('actions',$actions[0]['AUTH']);
	        }
	        return array('msg'=>'登陆成功！','state'=>'1');  
        }else{
        	return array('msg'=>'登陆失败！','state'=>'2');
        }
    }

     //退出
     function exituser(){
        
        if (Session::set('admin','')&&Session::set('actions','')) {
          //登陆成功保存session
          return array('msg'=>'退出成功！','state'=>'1');  
        }
    }
}
