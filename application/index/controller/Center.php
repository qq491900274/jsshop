<?php
namespace app\index\controller;
use think\mobile_controller;
use think\View;
use think\Request;
use think\Session;
 	 	 	
use \think\Db;


class Center extends mobile_controller
{	
	public function __construct(){
		parent::__construct();
	}
	
    public function index(){
    	return $this->fetch('center');
    }
    
    public function my_order(){
    	return $this->fetch('my_order');
    }

    public function my_center(){
    	return $this->fetch('my_center');
    }
}