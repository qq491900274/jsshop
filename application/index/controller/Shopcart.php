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
    	$table='SHOP_CART C LEFT JOIN SHOP_CURRICULUM CU ON CU.ID=C.CURRICULUMID'.
    			' LEFT JOIN SHOP_TEACHER T ON T.ID=CU.TEACHERGUID '.
    			' LEFT JOIN SHOP_SCHOOL S ON S.ID=CU.SCHOOLID';
    	$key='C.PRICE,C.ID CARTID,C.NUM,CU.NAME,CU.IMG,T.NAME TEACHERNAME,S.SCHOOL_NAME';
    	$where=" C.USERID='{$Request['id']}'"; 
    	return $this->pmodel->select($table,$key,$where);
	
    }

}
