<?php
namespace app\index\controller;
use think\Controller;
use think\View;
use think\mobile_controller;
use think\Request;
use think\Session;

use \think\Db;
use app\index\lib\Home;
use app\index\lib\JsApiPay;
use app\index\lib\WxPayUnifiedOrder;
use app\index\lib\WxPayConfig;
use app\index\lib\CLogFileHandler;
use app\index\lib\Log;

class Order extends mobile_controller
{	
	public function __construct(){
		parent::__construct();
	}
    //提交订单
    public function suborder(){
        $request=request()->post();
       
        if (empty($request)) {
            return $this->fetch('payment');
        }   
        //提交订单
        Db::startTrans();
        try{
            //判断是否超过库存
            $price=0;
            $goodsid='';
            foreach ($request['goodsid'] as $key => $value) {
                $where['ID']=$value['id'];
                $goodsinfo=Db::table('SHOP_CURRICULUM')
                            ->where($where)
                            ->select();
                $goodscount=(int)$goodsinfo[0]['COUNT']-(int)$goodsinfo[0]['USECOUNT'];
                if ($goodscount < $value['num']) {
                    return array('msg'=>"{$goodsinfo[0]['NAME']}库存不足！",'STATE'=>'2');
                    Db::rollback();
                }
                
                //计算总价格存放order
                $value['num']= $value['num']<='0' ? 1 :$value['num'];
                $price+=(float)$goodsinfo[0]['PRICE'] * (int)$value['num'];

                //记录商品id
                if (empty($goodsid)) {
                    $goodsid="'{$value['id']}'";
                }else{
                    $goodsid.=",'{$value['id']}'";
                }
            }
         //获取购物车查看是否还有值
         $ishave=Db::query("SELECT ID from SHOP_CART WHERE CURRICULUMID IN ({$goodsid}) AND USERID='{$_SESSION['userid']}'");
         if(empty($ishave)){
             return array('msg'=>"购物车商品已失效！",'STATE'=>'2');
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
            
         //商品上传到订单关联表中
         foreach($request['goodsid'] as $k=>$v){
            $data1['ID']=uniqid();
                $data1['CURRICULUMID']=$v['id'];
                $data1['ORDERID']=$data['ID'];
                $data1['NUM']=$v['num'];
                Db::table('SHOP_ORDERGOODS')->insert($data1);
         }
            //删除购物车商品   
            $where['USERID']=$_SESSION['userid'];
            $where['CURRICULUMID']=" IN ({$goodsid})";
            Db::query("delete from SHOP_CART WHERE CURRICULUMID IN ({$goodsid}) AND USERID='{$_SESSION['userid']}'");
           //添加消耗库存
            Db::query("UPDATE SHOP_CURRICULUM SET USECOUNT=USECOUNT+1 WHERE ID IN ({$goodsid})");

            // 提交事务
            Db::commit(); 
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            return array('msg'=>"提交订单失败！",'STATE'=>'2');
        }
        //调用支付
        $tools = new JsApiPay();
        $openId =$_SESSION['openid'];
        $input = new WxPayUnifiedOrder();
        $input->SetBody("金石教育-课程报名");
        $input->SetAttach($data['ID']);
        $input->SetOut_trade_no($data['CODE']);
        $input->SetTotal_fee((float)$price*'100');
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        $input->SetGoods_tag("jinshiedu");
        $input->SetNotify_url("http://shop.jinshiedu.com");
        $input->SetTrade_type("JSAPI");
        
        $input->SetOpenid($_SESSION['openid']);
        $config = new WxPayConfig();
        
        $order = Home::unifiedOrder($config, $input);
        
        $jsApiParameters = $tools->GetJsApiParameters($order);
    
       return array('msg'=>"提交订单成功！",'STATE'=>'1','jsApiParameters'=>$jsApiParameters,'id'=>$data['ID']);
    }
    
    //取消订单
    public function cancel_order(){
        $request=request()->post();
        $data['STATE']='3';
        Db::table('SHOP_ORDER')
                ->where('ID',$request['orderid'])
                ->update($data);
        
        //取消订单返回库存
        $goodsinfo=Db::table('SHOP_ORDERGOODS')
            ->where('ORDERID',$request['orderid'])
            ->select();
        
        foreach($goodsinfo as $key=>$val){
            Db::query("UPDATE SHOP_CURRICULUM SET USECOUNT=USECOUNT-1 WHERE ID='{$val['CURRICULUMID']}'");
        }
        return 1;
    }
    //我的订单，订单支付
    public function pay_order(){
      $request=request()->post();

      if(!empty($request['id'])){

        $where['ID']=$request['id'];
        $order=Db::table('SHOP_ORDER')->where($where)->select();
        if(empty($order)){
            return array('msg'=>'未查找到该订单！','state'=>'2');exit;
        }

        $money=$order[0]['PRICE'];
        $ordercode=$order[0]['CODE'];
        //调用支付
        $tools = new JsApiPay();
        $openId =$_SESSION['openid'];
        $input = new WxPayUnifiedOrder();
        $input->SetBody("金石教育-课程报名");
        $input->SetAttach($request['id']);
        $input->SetOut_trade_no($ordercode);
        $input->SetTotal_fee((float)$money*'100');
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        $input->SetGoods_tag("jinshiedu");
        $input->SetNotify_url("http://shop.jinshiedu.com");
        $input->SetTrade_type("JSAPI");
        
        $input->SetOpenid($_SESSION['openid']);
        $config = new WxPayConfig();
        
        $order = Home::unifiedOrder($config, $input);
        
        $jsApiParameters = $tools->GetJsApiParameters($order);
        
        return array('msg'=>"提交订单成功！",'state'=>'1','jsApiParameters'=>$jsApiParameters,'id'=>$request['id']);
      }
        return array('msg'=>'缺少订单id！','state'=>'2');exit;
    }
    public function notify_url(){
        $request=request()->post();
        $logHandler= new CLogFileHandler(dirname(__FILE__)."/../logs/".date('Y-m-d').'.log');
        $log = Log::Init($logHandler, 15);
        Log::ERROR(json_encode($request));
    return $this->fetch('index'); 
    }
    public function pay_success(){
        return $this->fetch('pay_success');
    }
}
