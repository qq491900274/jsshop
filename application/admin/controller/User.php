<?php
namespace app\admin\controller;
use think\Controller;
use think\View;
use think\Request;
use think\Session;

use \think\Db;

class User extends Controller
{	
	public function __construct(){
		parent::__construct();
	}
  //用户列表
  function userList(){
     return $this->fetch('userlist');
  }
  //删除用户
  function deleUser(){
     return 1;
  }
}
