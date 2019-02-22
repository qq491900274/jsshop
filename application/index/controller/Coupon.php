<?php
namespace app\index\controller;
use think\mobile_controller;
use think\View;
use think\Request;
use think\Session;
use think\Paginator;
use think\Upload;
use \think\Db;

header("Content-Type:text/html;charset=UTF-8");

class Coupon extends mobile_controller
{ 
  public function __construct(){
    parent::__construct();

  }
  
    public function index(){
    	$request=request()->post();
      if(!empty($request)){
      	  //返回购物券
      	  $thisdata=date('Y-m-d');
      	  $where['ENDTIME']=['>',$thisdata];
      	  $val=Db::table('SHOP_COUPON')
      	  		->where($where)
      	  		->select();
      	  return $val;
      }
      
      return $this->fetch('coupon');
    }
    
    //领取优惠券
    public function pull_coupon(){
		$request=request()->post();
		if(!empty($request['id'])){
			//判断库存是否足够
			$where['ID']=$request['id'];
			$coupon=Db::table('SHOP_COUPON')
						->where($where)
						->select();
			if(!count($coupon)){
				return array('msg'=>'未查询到有关优惠券!','state'=>'3');
			}
			
			$pullcoupon=Db::table('SHOP_USERCOUPON')
							->where('COUPONID',$request['id'])
							->count();
			if(!empty($pullcoupon) && $coupon[0]['COUNT']<$pullcoupon){
				return array('msg'=>'优惠券库存不足！','state'=>'4');
			}
			
			//查询优惠券领取条件
			$where['COUPONID']=$request['id'];
			$where['USERID']=$_SESSION['userid'];
			$countcoupon=Db::table('SHOP_USERCOUPON')->where($where)->count();
			
			if(!empty($coupon) && $countcoupon>$coupon[0]['MAXNUM']){
				return array('msg'=>'已经达到领取上限！','state'=>'5');
			}
			
			//记录领取记录
			$data['ID']=uniqid();
			$data['COUPONID']=$request['id'];
			$data['USERID']=$_SESSION['userid'];
			$data['STATE']='1';
			$data['DATETIME']=date('Y-m-d H:i:s');
			Db::table('SHOP_USERCOUPON')->insert($data);
			return array('msg'=>'领取成功！','state'=>'1');
		}else{
			return  array('msg'=>'未获取到id！','state'=>'2');
		}
    }
    
}
 