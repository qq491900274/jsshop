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
	
    public function index(){
    	$this->assign('name','123');
    	return $this->fetch('login'); 
    }
    //登陆
    public function Login_in()
    {
      var_dump(BASE_URL);
      $this->LoginModel =  new \app\index\model\LoginModvel();
      $result = $this->LoginModel->hello('helloword');
      return json_encode($result);
    }

    //验证密码功能
    public function getpwd(){
      $request = request()->post();

      if ($request['user']=='1' && $request['pwd']=='2') {
        return array('msg'=>'登陆成功！','state'=>'1');  
      }else{
        return array('msg'=>'登陆失败！','state'=>'2');
      }
    }

}
