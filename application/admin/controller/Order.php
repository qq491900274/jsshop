<?php
namespace app\admin\controller;
use think\Controller;
use think\View;
use think\Request;
use think\Session;

use \think\Db;


class Order extends Controller
{	
	public function __construct(){
		parent::__construct();
	}
		
    public function order_list(){
    	$request = request()->post();
    	//判断是否
    	if(empty($request['list'])){
    		return $this->fetch('order_list');
    	}
    }
   
}
