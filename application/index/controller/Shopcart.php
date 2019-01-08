<?php
namespace app\index\controller;
use think\mobile_controller;
use think\View;
use think\Request;
use think\Session;
 	 	 	
use \think\Db;


class Shopcart extends mobile_controller
{	
	public function __construct(){
		parent::__construct();
	}
	
    public function cart(){
    	$Request=request()->post();
		$this->pmodel =  new \app\index\model\PublicModel(); 

		if (empty($Request['list'])) {
			return $this->fetch('cart'); exit();	
		}
    	
		$key = "PRICE,COUNPONID,CURRICULUMID,ID,NUM";
		$where=" AREA='{$Request['area']}'";
		$table=" SHOP_CART C LEFT JOIN ";
		return $value = $this->pmodel->select($table,$key,$where);

    }

}
