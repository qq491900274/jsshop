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
            return Db::table('SHOP_ORDER')
                    ->where('USERID',$Request['id'])
                    ->select();
        }
    	return $this->fetch('my_order');
    }

    public function my_center(){

    	return $this->fetch('my_center');
    }
}
