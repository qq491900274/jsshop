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
	
   
    //返回购物车商品
    public function get_orderinfo(){
    	$request=request()->post();
    	$this->pmodel =  new \app\index\model\PublicModel(); 

    	if (empty($request['userid'])) {
    		return '未接受id！';
    	}

    	$table='SHOP_CART C LEFT JOIN SHOP_CURRICULUM CU ON CU.ID=C.CURRICULUMID'.
    			' LEFT JOIN SHOP_TEACHER T ON T.ID=CU.TEACHERGUID '.
    			' LEFT JOIN SHOP_SCHOOL S ON S.ID=CU.SCHOOLID';
    	$key='C.PRICE,C.ID CARTID,C.NUM,CU.NAME,CU.IMG,T.NAME TEACHERNAME,S.SCHOOL_NAME';
    	$where=" C.USERID='{$request['userid']}'";
    	$data['shop']=$this->pmodel->select($table,$key,$where);

    	//返回用户信息
        $data['userinfo']= Db::table('SHOP_USERS')
                ->where('ID',$request['userid'])
                ->select();

        return $data;
    }
    //提交订单
    public function suborder(){
    	$request=request()->post();
        
        if (empty($request['list'])) {
            return $this->fetch('payment');
        }	
        
    
    }
    
    //取消订单
    public function cancel_order(){
        $request=request()->post();
        $data['STATE']='3';
        Db::table('SHOP_ORDER')
                ->where('ID',$request['id'])
                ->update($data);
        return 1;
    }

    public function pay_success(){
        return $this->fetch('pay_success');
    }

}
