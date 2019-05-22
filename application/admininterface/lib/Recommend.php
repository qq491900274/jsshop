<?php
namespace app\admininterface\lib;
interface Recommend
{
	/**
	* phc 
	* pc head config--PC推荐课程
	* add it by Daniel at 2019/5/18 
	**/
	
	//后台推荐课程添加
	public function rmd_add();
	
	//后台推荐课程列表
	public function rmd_info();
	
	//后台推荐课程修改
	public function rmd_update();
	
	//后台返回单个商品
	public function rmd_getone();
	
	//后台推荐课程删除
	public function rmd_dele();
	
	/**
	* prc 
	* pc recommend course--推荐课程
	* add it by Daniel at 2019/5/18 
	**/
	
}
 