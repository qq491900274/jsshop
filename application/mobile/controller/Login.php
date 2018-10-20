<?php
namespace app\model\controller;
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
    	return $this->fetch('index'); 
    }
    public function Login_in()
    {
      $this->LoginModel =  new \app\index\model\LoginModel();
      $result = $this->LoginModel->hello('helloword');
      return json_encode($result);
    }
}
