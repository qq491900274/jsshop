<?php
namespace app\index\controller;
use think\mobile_controller;
use think\View;
use think\Request;
use think\Session;
use app\index\lib\Home;


class Index extends mobile_controller
{	
	public function __construct(){
		parent::__construct();
	}
		
    public function index(){
      $this->pmodel =  new \app\index\model\PublicModel(); 

      $key=" ID,PICURL imgUrl,URL imgHref,ORDERINDEX num";
      $where=" TYPE='imgLis'";
      $value['imgLis'] = $this->pmodel->select('SHOP_SLIDESHOWPIC',$key,$where);
      $this->assign('bannerlis',$value);
      $val=$this->http_curl('https://open.weixin.qq.com/connect/oauth2/authorize?appid=APPID&redirect_uri=REDIRECT_URI&response_type=code&scope=SCOPE&state=STATE#wechat_redirect');

      return $this->fetch('index'); 
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
}
