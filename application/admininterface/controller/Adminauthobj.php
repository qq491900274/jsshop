<?php
namespace app\admininterface\controller;
use \think\Db;
use app\admininterface\lib\AdminAuthHandler;
use app\admininterface\model\PublicModel;
class AdminAuthObj implements AdminAuthHandler
{
	public $ThisModel;
	public function __construct(){
		 $this->ThisModel =  new \app\admininterface\model\PublicModel();
	}
	/**
	* aac 
	* admin action config--后台功能配置
	* add it by Daniel at 2019/5/18 
	**/
	//后台功能增加
	public function aac_add(){
		$request = request()->post();
		if(!array_key_exists("URL",$request)||!array_key_exists("NAME",$request)){
			returnAjax('传参错误',1001);
		}
		if(!$request['URL']||!$request['NAME']){
			returnAjax('传参错误',1002);
		}
		$request['ID'] = get_uniqid();
		$request['GIDSTR'] = 1;
		$res = $this->ThisModel->add('ACTION',$request);
		if($res){
			returnAjax('添加成功',1);
		}else{
			returnAjax('添加失败',0);
		}
	}
	
	//功能所在的组
	public function acc_groups(){
		$request = request()->post();
		if(!array_key_exists("ID",$request)){
			returnAjax('传参错误',1001);
		}
		if(!$request['ID']){
			returnAjax('传参错误',1002);
		}
		if(!array_key_exists("PAGE",$request)||!$request['PAGE']){
			$page = 1;
		}else{
			$page = $request['PAGE'];
		}
		if(!array_key_exists("PAGESIZE",$request)||!$request['PAGESIZE']){
			$pagesize = 10;
		}else{
			$pagesize = $request['PAGESIZE'];
		}
		//开始查询的位置
		$start = ($page-1)*$pagesize;
		$gnamestr = $this->ThisModel->getone('ACTION','GIDSTR',array('ID'=>$request['ID']));
		$gnamearr = explode("|||",$gnamestr['GIDSTR']);
		unset($gnamearr[0]);
		$gnamearr = array_values($gnamearr);
		//总页码
		$totalpage = ceil(count($gnamearr)/$pagesize);
		if($page == $totalpage){
			$end = count($gnamearr);
		}else{
			$end = $start+$pagesize;
		}
		//返回的组名字数据
		$gname = array();
		for($i=$start;$i<$end;$i++){
			if($gnamearr[$i]){
				array_push($gname,$gnamearr[$i]);
			}
		}
		$data['gnames'] = $gname;
		$data['pages'] = $totalpage;
		returnAjax($data,1);
	}
	
	//后台功能删除
	public function aac_del(){
		$request = request()->post();
		if(!array_key_exists("ID",$request)){
			returnAjax('传参错误',1001);
		}
		if(!$request['ID']){
			returnAjax('传参错误',1002);
		}
		$res = $this->ThisModel->dele('ACTION',$request);
		if($res){
			returnAjax('删除成功',1);
		}else{
			returnAjax('删除失败',0);
		}
	}
	
	//后台功能修改
	public function aac_update(){
		$request = request()->post();
		if(!array_key_exists("ID",$request)){
			returnAjax('传参错误',1001);
		}
		if(!$request['ID']){
			returnAjax('传参错误',1002);
		}
		$where["ID"] = $request['ID'];
		unset($request['ID']);
		$res = $this->ThisModel->upd('ACTION',$where,$request);
		if($res){
			returnAjax('更新成功',1);
		}else{
			returnAjax('更新失败',0);
		}
	}
	
	//获取后台功能数据
	public function aac_get(){
		$request = request()->post();
		if(!array_key_exists("PAGE",$request)||!$request['PAGE']){
			$page = 1;
		}else{
			$page = $request['PAGE'];
		}
		if(!array_key_exists("PAGESIZE",$request)||!$request['PAGESIZE']){
			$pagesize = 10;
		}else{
			$pagesize = $request['PAGESIZE'];
		}
		$res = $this->ThisModel->select('ACTION','*',[],'sort asc',$page,$pagesize);
		$data['actions'] = $res;
		$total = $this->ThisModel->pcount('ACTION',[],$pagesize);
		$data['pages'] = $total;
		if($res){
			returnAjax($data,1);
		}else{
			returnAjax($data,0);
		}
	}
	/**
	* map 
	* manage admin people--管理员配置
	* add it by Daniel at 2019/5/18 
	**/
	//增加管理员
	public function map_add(){
		$request = request()->post();
		if(!array_key_exists("PHONE",$request)||!array_key_exists("NAME",$request)||!array_key_exists("PASSWORD",$request)||!array_key_exists("USER",$request)){
			returnAjax('传参错误',1001);
		}
		if(!$request['PHONE']||!$request['NAME']||!$request['PASSWORD']||!$request['USER']){
			returnAjax('传参错误',1002);
		}
		$request['ID'] = get_uniqid();
		$request['DATETIME'] = date('Y-m-d H:i:s',time());
		$res = $this->ThisModel->add('USER',$request);
		if($res){
			returnAjax('添加成功',1);
		}else{
			returnAjax('添加失败',0);
		}
	}
	
	//删除管理员
	public function map_del(){
		$request = request()->post();
		if(!array_key_exists("ID",$request)){
			returnAjax('传参错误',1001);
		}
		if(!$request['ID']){
			returnAjax('传参错误',1002);
		}
		$res = $this->ThisModel->dele('USER',$request);
		if($res){
			returnAjax('删除成功',1);
		}else{
			returnAjax('删除失败',0);
		}
	}
	
	//修改管理员
	public function map_update(){
		$request = request()->post();
		if(!array_key_exists("ID",$request)){
			returnAjax('传参错误',1001);
		}
		if(!$request['ID']){
			returnAjax('传参错误',1002);
		}
		$where["ID"] = $request['ID'];
		unset($request['ID']);
		$res = $this->ThisModel->upd('USER',$where,$request);
		if($res){
			returnAjax('更新成功',1);
		}else{
			returnAjax('更新失败',0);
		}
	}
	
	//管理员列表
	public function map_list(){
		$request = request()->post();
		if(!array_key_exists("PAGE",$request)||!$request['PAGE']){
			$page = 1;
		}else{
			$page = $request['PAGE'];
		}
		if(!array_key_exists("PAGESIZE",$request)||!$request['PAGESIZE']){
			$pagesize = 10;
		}else{
			$pagesize = $request['PAGESIZE'];
		}
		$res = $this->ThisModel->select('USER','*',[],'',$page,$pagesize);
		$data['admin'] = $res;
		$total = $this->ThisModel->pcount('USER',[],$pagesize);
		$data['pages'] = $total;
		if($res){
			returnAjax($data,1);
		}else{
			returnAjax($data,0);
		}
	}
	
	//管理员详情
	public function map_detail(){
		$request = request()->post();
		if(!array_key_exists("ID",$request)){
			returnAjax('传参错误',1001);
		}
		if(!$request['ID']){
			returnAjax('传参错误',1002);
		}
		$admininfo = $this->ThisModel->getone('USER','*',array('ID'=>$request['ID']));
		if($admininfo){
			returnAjax($admininfo,1);
		}else{
			returnAjax($admininfo,0);
		}
	}
	
	/**
	* dac 
	* distribution auth group--权限分组
	* add it by Daniel at 2019/5/18 
	**/
	//增加分组
	public function dac_add(){
		$request = request()->post();
		if(!array_key_exists("AUTH",$request)||!array_key_exists("NAME",$request)||!array_key_exists("AUTHNAME",$request)){
			returnAjax('传参错误',1001);
		}
		if(!$request['AUTH']||!$request['NAME']||!$request['AUTHNAME']){
			returnAjax('传参错误',1002);
		}
		$is_exist = $this->ThisModel->getone('AUTH','*',array('NAME'=>$request['NAME']));
		if($is_exist){
			returnAjax('添加失败',1003);
		}
		$autharr = json_decode($request["AUTH"]);
		$autharr = array_unique($autharr);
		$request['AUTH'] = implode('|||',$autharr);
		$authnamearr = json_decode($request["AUTHNAME"]);
		$authnamearr = array_unique($authnamearr);
		$request['AUTHNAME'] = implode('|||',$authnamearr);
		$primid = get_uniqid();
		Db::startTrans();
		for($i=0;$i<count($autharr);$i++){
			$act_own = $this->ThisModel->upd_concat('SHOP_ACTION','GIDSTR','|||'.$request['NAME'],"URL='".$autharr[$i]."'");
		}
		$request['ID'] = $primid;
		$request['CTIME'] = time();
		$res = $this->ThisModel->add('AUTH',$request);
		if($res){
			Db::commit();
			returnAjax('添加成功',1);
		}else{
			Db::rollback();
			returnAjax('添加失败',0);
		}
	}
	
	//删除分组
	public function dac_del(){
		$request = request()->post();
		if(!array_key_exists("NAME",$request)){
			returnAjax('传参错误',1001);
		}
		if(!$request['NAME']){
			returnAjax('传参错误',1002);
		}
		$res = $this->ThisModel->dele('AUTH',$request);
		if($res){
			returnAjax('删除成功',1);
		}else{
			returnAjax('删除失败',0);
		}
	}
	
	//修改分组名称
	public function dac_update(){
		$request = request()->post();
		if(!array_key_exists("ID",$request)){
			returnAjax('传参错误',1001);
		}
		if(!$request['ID']){
			returnAjax('传参错误',1002);
		}
		$where["ID"] = $request['ID'];
		if(array_key_exists("NAME",$request)||$request['NAME']){
			$data['NAME'] = $request['NAME'];
		}
		if((array_key_exists("AUTH",$request)||$request['AUTH'])&&(array_key_exists("AUTHNAME",$request)||$request['AUTHNAME'])){
			$autharr = json_decode($request["AUTH"]);
			$autharr = array_unique($autharr);
			$data['AUTH'] = implode('|||',$autharr);
			$authnamearr = json_decode($request["AUTHNAME"]);
			$authnamearr = array_unique($authnamearr);
			$data['AUTHNAME'] = implode('|||',$authnamearr);
		}
		
		Db::startTrans();
		for($i=0;$i<count($autharr);$i++){
			$act_own = $this->ThisModel->upd_concat('SHOP_ACTION','GIDSTR','|||'.$request['NAME'],"URL='".$autharr[$i]."'");
		}
		
		$res = $this->ThisModel->upd('AUTH',$where,$data);
		if($res){
			Db::commit();
			returnAjax('更新成功',1);
		}else{
			Db::rollback();
			returnAjax('更新失败',0);
		}
	}
	
	//分组列表
	public  function dac_get(){
		$request = request()->post();
		if(!array_key_exists("PAGE",$request)||!$request['PAGE']){
			$page = 1;
		}else{
			$page = $request['PAGE'];
		}
		if(!array_key_exists("PAGESIZE",$request)||!$request['PAGESIZE']){
			$pagesize = 10;
		}else{
			$pagesize = $request['PAGESIZE'];
		}
		if(!array_key_exists("NAME",$request)||!$request['NAME']){
			$where = [];
		}else{
			$where = array('NAME'=>$request['NAME']);
		}
		$res = $this->ThisModel->select('AUTH','*',$where,'',$page,$pagesize);
		foreach($res as $k=>$v){
			$groups[$k]['ID'] = $v['ID'];
			$autharr = explode("|||",$v['AUTHNAME']);
			$groups[$k]['AUTHS'] = count($autharr);
			$groups[$k]['NAME'] = $v['NAME'];
			$groups[$k]['CTIME'] = date("Y-m-d H:i:s",$v['CTIME']);
			$groups[$k]['ADMINS'] = $this->ThisModel->count('USER',['GNAME'=>$v['NAME']]);
			$groups[$k]['AUTHARR'] = $autharr;
		}
		$data['groups'] = $groups;
		$total = $this->ThisModel->pcount('AUTH',[],$pagesize);
		$data['pages'] = $total;
		if($res){
			returnAjax($data,1);
		}else{
			returnAjax($data,0);
		}
	}
	
	
	//查看分组功能权限
	public function dac_action(){
		$request = request()->post();
		if(!array_key_exists("PAGE",$request)||!$request['PAGE']){
			$page = 1;
		}else{
			$page = $request['PAGE'];
		}
		if(!array_key_exists("PAGESIZE",$request)||!$request['PAGESIZE']){
			$pagesize = 10;
		}else{
			$pagesize = $request['PAGESIZE'];
		}
		if(!array_key_exists("ACTIONS",$request)){
			returnAjax('传参错误',1001);
		}
		if(!$request['ACTIONS']){
			returnAjax('传参错误',1002);
		}
		$actions = json_decode($request['ACTIONS']);
		//开始查询的位置
		$start = ($page-1)*$pagesize;
		//总页码
		$totalpage = ceil(count($actions)/$pagesize);
		if($page == $totalpage){
			$end = count($actions);
		}else{
			$end = $start+$pagesize;
		}
		//返回的功能名字数据
		$aname = array();
		for($i=$start;$i<$end;$i++){
			if($actions[$i]){
				array_push($aname,$actions[$i]);
			}
		}
		$data['anames'] = $aname;
		$data['pages'] = $totalpage;
		returnAjax($data,1);
	}
	
	//查看分组管理员
	public function dac_admin(){
		$request = request()->post();
		if(!array_key_exists("PAGE",$request)||!$request['PAGE']){
			$page = 1;
		}else{
			$page = $request['PAGE'];
		}
		if(!array_key_exists("PAGESIZE",$request)||!$request['PAGESIZE']){
			$pagesize = 10;
		}else{
			$pagesize = $request['PAGESIZE'];
		}
		if(!array_key_exists("NAME",$request)){
			returnAjax('传参错误',1001);
		}
		if(!$request['NAME']){
			returnAjax('传参错误',1002);
		}
		$admins = $this->ThisModel->select('USER','*',array('GNAME'=>$request['name']),'',$page,$pagesize);
		$data['adminlist'] = $admins;
		$total = $this->ThisModel->pcount('USER',array('GNAME'=>$request['name']),$pagesize);
		$data['pages'] = $total;
		returnAjax($data,1);
	}
}
 