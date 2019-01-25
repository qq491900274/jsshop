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
