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
    public  function update_user(){
        $Request=request()->post();
        if (!empty($Request)) {
            $where['TYPE']=$Request['1'];
            Db::table('SHOP_SUBJECT')
                    ->where($where)
                    ->select();
            echo '1';
        }
    }
    public function get_class(){

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
