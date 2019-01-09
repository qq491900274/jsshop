<?php
namespace app\index\controller;
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
	
    public function pay(){
    	return $this->fetch('payment'); 
    }
     
}
