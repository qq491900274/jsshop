<?php
namespace app\pc\controller;
use think\pc_controller;
use think\View;
use think\Request;
use think\Session;
use \think\Db;


class Index extends  pc_controller
{	
	public function __construct(){
		parent::__construct();
		
	}
		 
    public function index(){
    	
      return $this->fetch('index'); 
    }
  public function test(){
    	echo 111;
    	$res = Db::name('COMPLAIN')->where('id','5cbbd592d5bf1')->find();
    	var_dump($res);
    	exit;
    }
}
