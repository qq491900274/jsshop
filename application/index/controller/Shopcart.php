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
	//查看购物车，与提交订单返回选中的商品方法
    public function cart(){
    	$request=request()->post();
		$this->pmodel =  new \app\index\model\PublicModel(); 

		if (empty($request['list'])) {
			return $this->fetch('cart'); exit();	
		}

		
    	$table='SHOP_CART C LEFT JOIN SHOP_CURRICULUM CU ON CU.ID=C.CURRICULUMID'.
    			' LEFT JOIN SHOP_TEACHER T ON T.ID=CU.TEACHERGUID '.
    			' LEFT JOIN SHOP_SCHOOL S ON S.ID=CU.SCHOOLID';
    	$key='C.PRICE,C.ID CARTID,C.NUM,CU.NAME,CU.IMG,CU.ID CURRICULUMID,T.NAME TEACHERNAME,S.SCHOOL_NAME';

    	$where=" C.USERID='{$request['userid']}'"; 
    	if (!empty($request['curriculumid'])) {
    		$shopid=str_replace(',',"','",$request['curriculumid']);
    		$where.=" AND  C.CURRICULUMID IN ('{$shopid}')";
    	}
    	return $this->pmodel->select($table,$key,$where);
	
    }
    //返回用户默认信息
    public function get_user(){
		$request=request()->post();
    	return Db::table('SHOP_USERS')
    			->where('ID',$request['userid'])
    			->select();
    }

    //修改购物车数量
    function update_cart(){
        $request=request()->post();
        if (empty($request['cartid'])) {
            return array('msg'=>'缺少购物车id','state'=>'2');
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
       		return array('msg'=>'课程库存不足','state'=>'2');
       	}
        //修改
        $data['NUM']=$request['num'];
        Db::table('SHOP_CART')
            ->where('ID',$request['cartid'])
            ->update($data);
        return 1;
    }

    function delete_cart(){
        $request=request()->post();
        if (empty($request['cartid'])) {
            return array('msg'=>'缺少购物车id','state'=>'2');
        }
$where['ID']=$request['cartid'];
        Db::table('SHOP_CART')
            ->where($where)
            ->delete();
        return 1;
    }

}