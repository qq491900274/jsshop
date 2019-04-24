<?php
namespace app\pc\controller;
use think\pc_controller;
use think\View;
use think\Request;
use think\Session;



class Download extends pc_controller
{	
	public function __construct(){
		parent::__construct();
		
		//判断用户是否登录
        // if(empty($_SESSION['user'])){
        // 	$this->error('请登录！',"HTTP://{$_SERVER['SERVER_NAME']}/tp?s=index/Login/index");
        // }
	}
		
    public function index(){
    
       return $this->fetch('pc_controller'); 
    }
   
}
