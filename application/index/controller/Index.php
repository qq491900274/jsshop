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
    
    //购物车
    public function shopping(){
    	return $this->fetch('shopping');
    }
}
