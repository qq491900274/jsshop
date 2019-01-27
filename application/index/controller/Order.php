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
        //提交订单
        Db::startTrans();
        try{
            //判断是否超过库存
            $price=0;
            $goodsid='';
            foreach ($request['num'] as $key => $value) {
                $where['ID']=$value['id'];
                $goodsinfo=Db::table('SHOP_CURRICULUM')
                            ->where($where)
                            ->select();
                if ($goodsinfo[0]['COUNT'] < $value['num']) {
                    return json_encode(array('msg'=>"{$goodsinfo[0]['NAME']}库存不足！",'STATE'=>'2'));
                    Db::rollback();
                }
                //计算总价格存放order
                $value['num']= $value['num']<='0' ? 1 :$value['num'];
                $price+=$goodsinfo['PRICE'] * $value['num'];

                //记录商品id
                if (empty($goodsid)) {
                    $goodsid="'{$value['id']}'";
                }else{
                    $goodsid.=",'{$value['id']}'";
                }
            }

            //获取优惠券价格

            //添加订单
            $data['ID']=uniqid();
            $data['CODE']=date('YmdHis').rand('000000','9999999');
            $data['PRICE']=$price;
            $data['USERID']=$_SESSION['userid'];
            $data['DATETIME']=date('Y-m-d H:i:s');
            $data['STATE']='1';
            Db::table('SHOP_ORDER')->insert($data);

            //删除购物车商品
            $where['USERID']=$_SESSION['userid'];
            $where['CURRICULUMID']=" IN ({$goodsid})";
            Db::table('SHOP_CART')->where($where)->delete();

            // 提交事务
            Db::commit(); 
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            return json_encode(array('msg'=>"提交订单失败！",'STATE'=>'2'));
        }
        //调用支付
        return json_encode(array('msg'=>"提交订单成功！",'STATE'=>'1'));
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
