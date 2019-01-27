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
      $request=request()->get();
      $key=" ID,PICURL imgUrl,URL imgHref,ORDERINDEX num";
      $where=" TYPE='imgLis'";
      $value['imgLis'] = $this->pmodel->select('SHOP_SLIDESHOWPIC',$key,$where);
      $this->assign('bannerlis',$value);

      if (!empty($request['code'])) {
        //获取openid
        $val=$this->http_curl("https://api.weixin.qq.com/sns/oauth2/access_token?appid=wx21f0eee318ecc6b2&secret=SECRET&code={$request['code']}&grant_type=authorization_code");

        $openid=$this->http_curl("https://api.weixin.qq.com/sns/userinfo?access_token={$val['access_token']}&openid=wx21f0eee318ecc6b2&lang=zh_CN");
        var_dump($openid);

        if (!empty($openid)) {
          //判断用户是否存在
          $isuser=Db::table('SHOP_USERS')
                  ->where('WXNO',$openid['openid'])
                  ->select();
          if(empty($isuser)){
            //用户不存在
            $data['WXNO']=$openid['openid'];
            $data['NAME']=$openid['nickname'];
            $data['SEX']=$openid['sex'];
            $data['PIC']=$openid['headimgurl'];
            $data['ID']=uniqid();

            Db::table('SHOP_USERS')
            ->insert($data);
          }

          Session::set('userid',$isuser['ID']);
        }  
      }
      

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

    //活动页面
    public function activity(){
      $request=request()->post();
      if (empty($request)) {
        return $this->fetch('activity');
      }

      $where['PHONE']=$request['phone'];
      $ishave=Db::table('SHOP_ACTIVITY')->where($where)->select();
      if(!empty($ishave)){
        //提交活动信息
        $insert['ID']=uniqid();
        $insert['NAME']=$request['name'];
        $insert['PHONE']=$request['phone'];
        $insert['SCHOOL']=$request['school'];
        $insert['SUBJECT']=$request['subject'];
        $insert['utm_source']=$request['utm_source']);
        $insert['utm_medium']=$request['utm_medium'];
        $insert['utm_term']=$request['utm_term'];
        $insert['utm_content']=$request['utm_content'];
        $insert['utm_campaign']=$request['utm_campaign'];
        Db::table('SHOP_ACTIVITY')->insert($insert); 
        return 1;
      }else{
        return 2;
      }
      
    }
}
