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
    	$key='C.PRICE,C.ID CARTID,C.NUM,CU.NAME,CU.IMG,CU.ID CURRICULUMID,T.NAME TEACHERNAME,S.SCHOOL_NAME';
    	$where=" C.USERID='{$Request['id']}'"; 
    	return $this->pmodel->select($table,$key,$where);
	
    }

    //修改购物车数量
    function update_cart(){
        $request=request()->post();
        if (empty($request['cartid'])) {
            return json_encode(array('msg'=>'缺少购物车id'));
        }

        //判断库存是否足够
        $shopnum=Db::table('SHOP_CURRICULUM')
                    ->where('ID',$request['curriculumid'])
                    ->select();
        //获取已使用库存
        $ordernum=Db::table('SHOP_ORDERGOODS')
                    ->where('CURRICULUMID',$request['curriculumid'])
                    ->sum('NUM');

       	if($shopnum[0]['COUNT']<($ordernum+$request['num'])){
       		return json_encode(array('msg'=>'课程库存不足'));
       	}
        //获取所有

        Db::table('SHOP_CART')
            ->where('ID',$request['cartid'])
            ->update('NUM',$request['num']);
        return 1;
    }
}
