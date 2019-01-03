<?php
namespace app\admin\controller;
use think\Controller;
use think\View;
use think\Request;
use think\Session;

use \think\Db;

class Account extends Controller
{	
	public function __construct(){
		parent::__construct();
	}

 	public function index()
    {
    	$request=request()->post();
    	if (!empty($Request['list']) && $Request['list']=='1') {
	      $where='1=1';

	      if (!empty($Request['id']) && $Request=='1 ') {
	        $where.=" AND ID='{$Request['id']}'";
	      }
	      
	      //获取post当前页数。与查询条件。
	      $maxpage = empty($request['page'])?'19':20*$request['page']-1;
	      $minpage = $maxpage-19;
	      
	      $count=$this->pmodel->select('SHOP_ACCOUNT ','count(ID) num',$where)[0]['num'];
	      //获取查询条件
	      $where .= " LIMIT {$minpage},{$maxpage}";
	      
	      $key = "ID,NAME,COUPONURL,PRICE,ISWHERE,WHEREPRICE,MAXNUM,COUNT,STARTTIME,ENDTIME,CONTENT,DATETIME,PIC";
	      $result['value'] = $this->pmodel->select('SHOP_ACCOUNT',$key,$where);
	      $result['page'] = empty($request['page']) ? '1' : $request['page'];
	      
	      $result['allCount'] = ceil($count/20);
	      //返回校区数据
	      return $result;
	    }
    	return $this->fetch('account');
    }

    public function delaccount(){
    	$Request=request()->post();

    	if (empty($where['id'])) {
    		echo '未获取到id'；
    	}

    	$where['ID']=$Request['id'];
    	Db::table('SHOP_ACCOUNT')->where($where)->delete();
    	return 1;
    }
 
}
