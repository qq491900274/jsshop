<?php
namespace app\admin\controller;
use think\Controller;
use think\View;
use think\Request;
use think\Session;

use \think\Db;

class User extends Controller
{	
	public function __construct(){
		parent::__construct();
	}
  //用户列表
  function userList(){
    $request = request()->post();
    //判断是否只请求页面
    if(empty($request['list'])){
       return $this->fetch('userlist');
    }

    $request['page']=empty($request['page'])?'1':$request['page'];

    $this->pmodel =  new \app\admin\model\PublicModel();
    $where=" ifnull(id,0) != 0";
    
    if(!empty($request['where']['name'])){
      $where.=" and NAME='{$request['where']['name']}' ";
    }
    if(!empty($request['where']['phone'])){
      $where.=" and PHONE='{$request['where']['phone']}' ";
    }

    //获取分页查询条件
    $page=$this->return_page($request['page']);
    
    $where1 =$where. " LIMIT {$page['min']},{$page['max']}";

    $key = "ID,NAME,PHONE,DATETIME,WXNO,PASSWORD,USER";
    $table="SHOP_USER";
    $result['value'] = $this->pmodel->select($table,$key,$where1);
    
    //返回总页数
    $count=$this->pmodel->select('SHOP_USER','count(ID) num ',$where);
    if(!empty($count)){
       $result['allCount'] = ceil( $count[0]['num']/ 20);
    }
    //返回校区数据
    return $result;
     
  }
  function get_onevalue(){
    $request = request()->post();
    if (empty($request['id'])) {
      return '缺少id！';
    }

    $this->pmodel =  new \app\admin\model\PublicModel();
    $key = "ID,NAME,PHONE,DATETIME,WXNO,PASSWORD,USER";
    $table="SHOP_USER";
    $where=" ID='{$request['id']}'";
    return $result['value'] = $this->pmodel->select($table,$key,$where);
  }
  function updateUser(){
    $request = request()->post();
      if (!empty($request)) {
        $time=date('Y-m-d H:i:s');
        $data=['NAME'=>$request['name'],
              'PHONE'=>$request['phone'],
              'PASSWORD'=>$request['pwd'],
              'USER'=>$request['user'],
              'DATETIME'=>$time
              ];

        if (!empty($request['id'])) {
          $isok=DB::table('SHOP_USER')
              ->where('ID',$request['id'])
              ->update($data);
        }else{
          $data['ID']=uniqid();
          $isok=DB::table('SHOP_USER')
              ->insert($data);
        }

        echo '1';exit();
      }

      return $this->fetch('updateUser');
  }

  //删除用户
  function deleUser(){
      $request = request()->post();
      //判断是否
      if(empty($request['id'])){
        $data=['STATE'=>'1'];
        $isok=DB::table('SHOP_USER')
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
