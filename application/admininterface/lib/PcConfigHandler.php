<?php
namespace app\admininterface\lib;
interface PcConfigHandler
{
	/**
	* phc 
	* pc head config--PC导航配置
	* add it by Daniel at 2019/5/18 
	**/
	
	//后台导航配置增加
	public function phc_add();
	
	//后台导航配置展示
	public function phc_show();
	
	//后台导航配置取消展示
	public function phc_cancelshow();
	
	//后台导航配置删除
	public function phc_del();
	
	//后台导航配置修改
	public function phc_update();
	
	/**
	* prc 
	* pc recommend course--推荐课程
	* add it by Daniel at 2019/5/18 
	**/
	
}
 