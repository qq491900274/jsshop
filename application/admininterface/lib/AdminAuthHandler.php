<?php
namespace app\admininterface\lib;
interface AdminAuthHandler
{
	/**
	* aac 
	* admin action config--后台权限配置
	* add it by Daniel at 2019/5/18 
	**/
	//后台功能增加
	public function aac_add();
	
	//后台功能删除
	public function aac_del();
	
	//后台功能修改
	public function aac_update();
	
	//获取后台功能数据
	public function aac_get();
	/**
	* map 
	* manage admin people--推荐课程
	* add it by Daniel at 2019/5/18 
	**/
	//增加管理员
	public function map_add();
	
	//删除管理员
	public function map_del();
	
	//修改管理员
	public function map_update();
	
	/**
	* dac 
	* distribution auth group--权限分组
	* add it by Daniel at 2019/5/18 
	**/
	//增加分组
	public function dac_add();
	
	//删除分组
	public function dac_del();
	
	//修改分组
	public function dac_update();
}
 