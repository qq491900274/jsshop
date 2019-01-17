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
    	$table='SHOP_CART C LEFT JOIN SHOP_CURRICULUM CU ON CU.ID=C.CURRICULUMID';
    	$key='C.PRICE,C.ID CARTID,C.NUM,CU.NAME,CU.IMG';
    	$where=" USERID='{$request['id']}'";
    	return $data['shop']=$this->pmodel->select($table,$key,$where);
	
    }

}
