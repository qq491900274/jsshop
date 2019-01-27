<?php
namespace app\index\controller;
use think\Controller;
use think\View;
use think\Request;
use think\Session;
use app\index\lib\Home;//deng xia
use \think\Db;

class Home extends Controller
{	

    public function activity(){
    	$request=request()->post();
    	if (empty($request)) {
    		return $this->fetch('activity');
    	}

    	//返回信息
    	return Db::table('SHOP_ACTIVITY')->select();
    }
}
