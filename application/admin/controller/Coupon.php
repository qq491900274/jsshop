<?php
namespace app\admin\controller;
use think\Controller;
use think\View;
use think\Request;
use think\Session;

use \think\Db;

class Coupon extends Controller
{	
	public function __construct(){
		parent::__construct();
	}

  public function index(){
    return $this->fetch('coupon');
  }
  
}
