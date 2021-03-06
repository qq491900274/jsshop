<?php
namespace app\admin\controller;
use think\Controller;
use think\View;
use think\Request;
use think\Session;
use app\index\lib\Home;
use \think\Db;

class Index extends Controller
{	
	public function __construct(){
		parent::__construct();

	}

    public function activity(){
      
      $request=request()->post();
      if (empty($request)) {
        return $this->fetch('activity');
      }

      $this->pmodel =  new \app\index\model\PublicModel();
      $where='1=1';
      if (!empty($request['utm_source'])) {
        $where.=' and utm_source like "%'.$request['where']['utm_source'].'"';
      }
      //获取post当前页数。与查询条件。
      $maxpage = empty($request['page'])?'19':20*$request['page']-1;
      $minpage = $maxpage-19; 
      
      $count=$this->pmodel->select('SHOP_ACTIVITY ','count(ID) num',$where)[0]['num'];
      //获取查询条件
      $where .= " LIMIT {$minpage},{$maxpage}";
      
      
      $key = "ID,NAME,PHONE,SCHOOL,STATE,SUBJECT,utm_source,utm_medium,utm_term,utm_content,utm_campaign,DATETIME";
      $result['value'] = $this->pmodel->select('SHOP_ACTIVITY',$key,$where);
      $result['page'] = empty($request['page']) ? '1' : $request['page'];
      
      $result['allCount'] = ceil($count/20);
      //返回
      return $result;
    }
    //反馈方法
    public function complain(){
      
      $request=request()->post();
      if (empty($request)) {
        return $this->fetch('complain');
      }

      $this->pmodel =  new \app\index\model\PublicModel();
      $where='1=1';
      //获取post当前页数。与查询条件。
      $maxpage = empty($request['page'])?'19':20*$request['page']-1;
      $minpage = $maxpage-19; 
      
      $count=$this->pmodel->select('SHOP_COMPLAIN ','count(ID) num',$where)[0]['num'];
      //获取查询条件
      $where .= " LIMIT {$minpage},{$maxpage}";
      
      
      $key = "ID,PHONE,IP,CONTENT";
      $result['value'] = $this->pmodel->select('SHOP_COMPLAIN',$key,$where);
      $result['page'] = empty($request['page']) ? '1' : $request['page'];
      
      $result['allCount'] = ceil($count/20);
      //返回
      return $result;
    }
    function delete_complain(){
      $request=request()->post();
      if (!empty($request)) {
        Db::table('SHOP_COMPLAIN')
            ->where('ID',$request['id'])
            ->delete();

        return 1;
      }
    }

    function delete_activity(){
      $request=request()->post();
      if (!empty($request)) {
        Db::table('SHOP_ACTIVITY')
            ->where('ID',$request['id'])
            ->delete();

        return 1;
      }
    }

    function update_activity(){
      $request=request()->post(); 
      if (!empty($request)) {
        $data['STATE']='1';
        Db::table('SHOP_ACTIVITY')
            ->where('ID',$request['id'])
            ->update($data);

        return 1;
      }
    }
    
  
}
