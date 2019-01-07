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

		if (!empty($Request['list']) && $Request['list']=='1') {
			return $this->fetch('cart'); 	
		}
    	
    	if (empty($_SESSION['USERID'])){
    		return json_encode(array('msg'=>'未获取到用户名id'));
    	}

		$key = "PRICE,COUNPONID,CURRICULUMID,ID,NUM";
		$where=" AREA='{$Request['area']}'";
		$table=" SHOP_CART C LEFT JOIN ";
		return $value = $this->pmodel->select(,$key,$where);

    }

}
