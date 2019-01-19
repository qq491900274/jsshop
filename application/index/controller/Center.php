<?php
namespace app\index\controller;
use think\mobile_controller;
use think\View;
use think\Request;
use think\Session;
 	 	 	
use \think\Db;


class Center extends mobile_controller
{	
	public function __construct(){
		parent::__construct();
	}
	
    public function index(){
        $Request=request()->post();
        if (!empty($Request['list']) && $Request['list']=='1') {
            return Db::table('SHOP_USERS')
                    ->where('ID',$Request['id'])
                    ->select();
        }
        
    	return $this->fetch('center');
    }
    //修改用户信息
    public  function update_user(){
        $Request=request()->post();
        if (!empty($Request)) {
            $where['ID']=$Request['ID'];
            Db::table('SHOP_USERS')
                    ->where($where)
                    ->update($Request);
            echo '1';
        }
    }
    //返回课程
    public function get_class(){
        $Request=request()->post();
        $where['TYPE']='1';
        return Db::table('SHOP_SUBJECT')
                ->where($where)
                ->select();
    }
    public function my_order(){
        $Request=request()->post();
        if (!empty($Request['list']) && $Request['list']=='1') {
            $this->pmodel =  new \app\index\model\PublicModel();
            $table='SHOP_ORDER O LEFT JOIN SHOP_CURRICULUM C ON C.ID=O.CURRICULUMID '
                    .'LEFT JOIN SHOP_TEACHER T ON T.ID=C.TEACHERGUID '
                    .'LEFT JOIN SHOP_SCHOOL S ON S.ID=C.SCHOOLID';
            $key='O.STATE,O.ID,O.DATETIME,C.PRICE,'.
                'S.NAME SCHOOLNAME,T.NAME TEACHERNAME,C.NAME GOODSNAME,C.PIC';
            $where=" O.USERID='{$Request['id']}'"; 
            return $this->pmodel->select($table,$key,$where);
        }
    	return $this->fetch('my_order');
    }

    public function my_center(){

    	return $this->fetch('my_center');
    }

    //优惠券
    public function my_coupon(){
        $Request=request()->post();
        $this->pmodel =  new \app\index\model\PublicModel(); 
        if (empty($Request['list'])) {
            return $this->fetch('my_coupon');
        }

        $table='SHOP_USERCOUPON U LEFT JOIN SHOP_COUPON C ON C.ID=U.COUPONID';
        $key='U.STATE,U.ID,U.DATETIME,C.STARTTIME,C.ENDTIME,C.NAME,C.PRICE,C.PIC,U.COUPONID';
        $where=" USERID='{$Request['userid']}'"; 
        return $this->pmodel->select($table,$key,$where);
    }
}
