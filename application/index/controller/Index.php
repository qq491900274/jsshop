<?php
namespace app\index\controller;
use think\mobile_controller;
use think\View;
use think\Request;
use think\Session;
use \think\Db;
use app\index\lib\CLogFileHandler;
use app\index\lib\Log;

class Index extends mobile_controller
{	
	public function __construct(){
		parent::__construct();
	}
	
    public function index(){
    	$this->pmodel =  new \app\index\model\PublicModel(); 
    	
      //因url路由模式。此方法同时也作为微信支付回调
      $xml = file_get_contents('php://input');
      
      if(!empty($xml)){
      	  $arr=$this->xmlToArray($xml);
      	  if($arr['result_code']=='SUCCESS'  && $arr['return_code']=='SUCCESS' && !empty($arr['transaction_id'])){
      	  	  $thistime=date('Y-m-d H:i:s');
      	  	  $set=" STATE='6',PAYCODE='{$arr['transaction_id']}',PAYTIME='{$thistime}' ";
      	  	  $where="ID='{$arr['attach']}'";
      	  	  $this->pmodel->update_all('SHOP_ORDER',$set,$where);
      	  	  return '<xml> <return_code><![CDATA[SUCCESS]]></return_code> <return_msg><![CDATA[OK]]></return_msg> </xml>';
			  exit;
      	  }
      }
      
      
      $request=request()->get();
      $key=" ID,PICURL imgUrl,URL imgHref,ORDERINDEX num";
      $where=" TYPE='imgLis'";
      $value['imgLis'] = $this->pmodel->select('SHOP_SLIDESHOWPIC',$key,$where);
      $this->assign('bannerlis',$value);
      $request1=request()->post();
     
	    return $this->fetch('index'); 
    }
    //微信支付回调使用
    function xmlToArray($xml)
    {
        //禁止引用外部xml实体
        libxml_disable_entity_loader(true);
        $values = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        return $values;
    }
    public function get_index()
    {
        $this->pmodel =  new \app\index\model\PublicModel(); 

        $key = "ID,PHONE,PHONE1";
        $value = $this->pmodel->select('SHOP_SLIDESHOW',$key);

        if (!empty($value)) {
           //查询轮播图
           $key=" ID,PICURL imgUrl,URL imgHref,ORDERINDEX num";
           $where=" TYPE='bannerLis'";
           $value[0]['bannerLis'] = $this->pmodel->select('SHOP_SLIDESHOWPIC',$key,$where);
           $where=" TYPE='imgLis'";
           $value[0]['imgLis'] = $this->pmodel->select('SHOP_SLIDESHOWPIC',$key,$where);
           $where=" TYPE='hotLis'";
           $value[0]['hotLis'] = $this->pmodel->select('SHOP_SLIDESHOWPIC',$key,$where);
           return $value[0];
        }
    }
    public function get_school(){
      //根据省获取校区
      $Request=request()->post();
      $this->pmodel =  new \app\index\model\PublicModel(); 

      $key = "SCHOOL_NAME,ID";
      $where=" AREA='{$Request['area']}'";
      return $value = $this->pmodel->select('SHOP_SCHOOL',$key,$where);
    }

    public function get_coupon(){
      $Request=request()->post();
      $this->pmodel =  new \app\index\model\PublicModel(); 

      $where='1=1';
      if (!empty($Request['id'])) {
        $where.=" AND ID='{$Request['id']}'";
      }

      $where.=" ORDER BY STARTTIME DESC LIMIT 5";
      $key = "ID,NAME,COUPONURL,PRICE,ISWHERE,WHEREPRICE,MAXNUM,COUNT,STARTTIME,ENDTIME,CONTENT,DATETIME,PIC";
      $result['value'] = $this->pmodel->select('SHOP_COUPON',$key,$where);
      //返回校区数据
      return $result;
    }

    //活动页面
    public function activity(){
      $request=request()->post();
      if (empty($request)) {
        return $this->fetch('activity');
      }

      $where['PHONE']=$request['phone'];
      $ishave=Db::table('SHOP_ACTIVITY')->where($where)->select();
      
      if(count($ishave)<='0'){
        //提交活动信息
        $insert['ID']=uniqid();
        $insert['NAME']=$request['name'];
        $insert['PHONE']=$request['phone'];
        $insert['SCHOOL']=$request['school'];
        $insert['SUBJECT']=$request['subject'];
        $insert['utm_source']=$request['utm_source'];
        $insert['utm_medium']=$request['utm_medium'];
        $insert['utm_term']=$request['utm_term'];
        $insert['utm_content']=$request['utm_content'];
        $insert['utm_campaign']=$request['utm_campaign'];
        $insert['DATETIME']=date('Y-m-d H:i:s');
        Db::table('SHOP_ACTIVITY')->insert($insert); 
        return 1;
      }else{
        return 2;
      }
      
    }
  public function complain(){
      //添加反馈建议
      if(!empty($request['phone'])){
        $where['PHONE']=$request['phone'];
        $ishave=Db::table('SHOP_COMPLAIN')->where($where)->select();
      }

      if(count($ishave)<='0'){
        //提交活动信息
        $insert['ID']=uniqid();
        $insert['PHONE']=$request['phone'];
        $insert['IP']=$request['ip'];
        $insert['CONTENT']=$request['content'];
        Db::table('SHOP_COMPLAIN')->insert($insert); 
        return 1;
      }else{
        return 2;
      }
  }
  public function expand(){
    $request=request()->post();
    if (empty($request)) {
      return $this->fetch('expand');
    }
  }

  public function activity2(){
    $request=request()->post();
    if (empty($request)) {
      return $this->fetch('activity2');
    }
  }
  public function service(){
    $request=request()->post();
    if (empty($request)) {
      return $this->fetch('service');
    }
  }

  public function jxClass(){
    $request=request()->post();
    if (empty($request)) {
      return $this->fetch('jxClass');
    }
  }

  public function seminar(){
    $request=request()->post();
    if (empty($request)) {
      return $this->fetch('seminar');
    }
  }


}



