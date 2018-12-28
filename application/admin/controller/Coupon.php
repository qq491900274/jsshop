<?php
namespace app\admin\controller;
use think\Controller;
use think\View;
use think\Request;
use think\Session;

use \think\Db;

class Coupon extends Controller
{	
	public function __construct(){
		parent::__construct();
	}

  public function index(){
    $Request=request()->post();
    $this->pmodel =  new \app\index\model\PublicModel(); 

    if (!empty($Request['list']) && $Request['list']=='1') {
      $where='1=1';

      if (!empty($Request['id']) && $Request=='1 ') {
        $where.=" AND ID='{$Request['id']}'";
      }
      
      //获取post当前页数。与查询条件。
      $maxpage = empty($request['page'])?'19':20*$request['page']-1;
      $minpage = $maxpage-19;
      
      $count=$this->pmodel->select('SHOP_COUPON ','count(ID) num',$where)[0]['num'];
      //获取查询条件
      $where .= " LIMIT {$minpage},{$maxpage}";
      
      $key = "ID,NAME,COUPONURL,PRICE,ISWHERE,WHEREPRICE,MAXNUM,COUNT,STARTTIME,ENDTIME,CONTENT,DATETIME,PIC";
      $result['value'] = $this->pmodel->select('SHOP_COUPON',$key,$where);
      $result['page'] = empty($request['page']) ? '1' : $request['page'];
      
      $result['allCount'] = ceil($count/20);
      //返回校区数据
      return $result;
    }
    return $this->fetch('coupon');
  }
  
  public function update_coupon(){
    $Request=request()->post();

    if (!empty($request)) {
      $time=date('Y-m-d H:i:s');
      $data=['NAME'=>$request['name'],
            'COUPONURL'=>$request['couponurl'],
            'PRICE'=>$request['price'],
            'ISWHERE'=>$request['iswhere'],
            'WHEREPRICE'=>$request['whereprice'],
            'MAXNUM'=>$request['maxnum'],
            'COUNT'=>$request['count'],
            'STARTTIME'=>$request['starttime'],
            'ENDTIME'=>$request['endtime'],
            'CONTENT'=>$request['content'],
            'PIC'=>$request['pic'],
            ];

      if (!empty($request['id'])) {
        DB::table('SHOP_COUPON')
            ->where('ID',$request['id'])
            ->update($data);
      }else{
        $data['ID']=uniqid();
        $data['DATETIME']=date('Y-m-d H:i:s');
        DB::table('SHOP_COUPON')
            ->insert($data);
      }

      echo '1';exit();
    }

    return $this->fetch('update_coupon');
  }

  public function delete_coupon(){
    $this->pmodel =  new \app\admin\model\PublicModel();

    $request = request()->post();
    $id=str_replace(',', "','", $request['id']);
    if (empty($id)) {
      return;
    }
    $where=" ID IN ('{$id}')";
    $isok=$this->pmodel->dele('SHOP_COUPON',$where);
    
    return '1';

  }
}
