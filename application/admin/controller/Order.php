<?php
namespace app\admin\controller;
use think\Controller;
use think\View;
use think\Request;
use think\Session;

use \think\Db;


class Order extends Controller
{	
	public function __construct(){
		parent::__construct();
	}
		
    public function order_list(){
	  $request = request()->post();
	  //判断是否只请求页面
 	  if(empty($request['list'])){
	 	return $this->fetch('order_list');
	  }

      $request['page']=empty($request['page'])?'1':$request['page'];

      $this->pmodel =  new \app\admin\model\PublicModel();
      $where=" 1=1";
      if(!empty($request['where']['orderCode'])){
        $where.=" and O.CODE='{$request['where']['orderCode']}' ";
      }
      if(!empty($request['where']['name'])){
        $where.=" and U.NAME='{$request['where']['name']}' ";
      }
      if(!empty($request['where']['phone'])){
        $where.=" and U.PHONE='{$request['where']['phone']}' ";
      }
      
      //获取分页查询条件
      $page=$this->return_page($request['page']);
      
      $where1 =$where. " LIMIT {$page['min']},{$page['max']}";

      $key = "O.ID,O.CODE,O.PAYCODE,O.PRICE,O.DATETIME,O.PAYTIME,O.STATE,".
             "U.NAME,U.PHONE,C.NAME,C.PRICE CPRICE";
      $table=" SHOP_ORDER O LEFT JOIN SHOP_USER U ON U.ID=O.USERID".
             " LEFT JOIN SHOP_CURRICULUM C ON C.ID=O.CURRICULUMID";

      $result['value'] = $this->pmodel->select($table,$key,$where1);
      
      //返回总页数
      $count=$this->pmodel->select('SHOP_ORDER','count(ID) num ',$where);
      if(!empty($count)){
         $result['allCount'] = ceil( $count[0]['num']/ 20);
      }
      //返回校区数据
      return $result;
    }

    public function delete_order(){
      $request = request()->post();
      //判断是否
      if(empty($request['id'])){
        $data=['STATE'=>'1'];
        $isok=DB::table('SHOP_TEACHER')
          ->where('ID',$request['id'])
          ->update($data);
        return 1;
      }
      
    }
    public function return_page($request){
        //获取post当前页数。与查询条件。
        $page['max'] = empty($request)?'19':20*$request-1;
        $page['min'] = $page['max']-19;

        return $page;
    }
   
}
