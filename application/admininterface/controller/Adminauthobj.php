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
		$res = $this->ThisModel->add('ACTION',$request);
		if($res){
			returnAjax('添加成功',1);
		}else{
			returnAjax('添加失败',0);
		}
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
		
	}
	
	//获取后台功能数据
	public function aac_get(){
		
	}
	/**
	* map 
	* manage admin people--推荐课程
	* add it by Daniel at 2019/5/18 
	**/
	//增加管理员
	public function map_add(){
		
	}
	
	//删除管理员
	public function map_del(){
		
	}
	
	//修改管理员
	public function map_update(){
		
	}
	
	/**
	* dac 
	* distribution auth group--权限分组
	* add it by Daniel at 2019/5/18 
	**/
	//增加分组
	public function dac_add(){
		
	}
	
	//删除分组
	public function dac_del(){
		
	}
	
	//修改分组
	public function dac_update(){
		
	}
}
 