<?php
namespace app\admin\controller;
use think\Controller;
use think\View;
use think\Request;
use think\Session;
use app\index\lib\Home;


class Order extends Controller
{	
	public function __construct(){
		parent::__construct();
	}
		
    public function order_list(){
       return $this->fetch('order_list');
    }
   
}
