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
    $Request=request()->post();
    $this->pmodel =  new \app\index\model\PublicModel(); 

    if (!empty($Request['list'])) {


      return 1;
    }
    return $this->fetch('coupon');
  }
  
  public function update_coupon(){
    $Request=request()->post();
    $this->pmodel =  new \app\index\model\PublicModel(); 

    if (!empty($Request['list'])) {


      return 1;
    }
    return $this->fetch('update_coupon');
  }
}
