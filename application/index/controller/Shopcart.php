<?php
namespace app\index\controller;
use think\Controller;
use think\View;
use think\Request;
use think\Session;

use \think\Db;


class Shopcart extends mobile_controller
{	
	public function __construct(){
		parent::__construct();
	}
	
    public function index(){
    	return $this->fetch('cart'); 
    }
   
}
