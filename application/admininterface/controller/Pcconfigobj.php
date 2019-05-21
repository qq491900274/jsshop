<?php
namespace app\admininterface\controller;
use \think\Db;
use app\admininterface\lib\PcConfigHandler;
class PcConfigObj implements PcConfigHandler
{ 
	public $ThisModel;
	public function __construct(){
		 $this->ThisModel =  new \app\admininterface\model\PublicModel();
	}
	/**
	* phc 
	* pc head config--PC导航配置
	* add it by Daniel at 2019/5/18 
	**/

	//后台导航配置增加
	public function phc_add(){
		$request = request()->post();
		//判断是否有参数
		if (!empty($request)) {
			if (empty($request['name'])) {
				returnAjax('导航名称不能为空！','0');
			}

			if (empty($request['url'])) {
				returnAjax('导航连接不能为空！','0');
			}

			$insert['ID']=get_uniqid();
			$insert['NAME']=$request['name'];
			$insert['URL']=$request['url'];
			$insert['SORTNUM']=(int)$request['sortnum'];
			$res=$ThisModel->add('SHOP_PCHEADER',$insert);

			if ($res) {
				returnAjax('添加成功!','1');
			}else{
				returnAjax('添加失败',0);
			}

		}else{
			returnAjax('参数错误！','0');
		}
	}

	//后台导航配置展示
	public function phc_show(){
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
		//获取当前页数据
		$val = $this->ThisModel->select('PCHEADER','ID,NAME,URL,SORTNUM','','SORTNUM',$page,$pagesize);
		
		//总数
		$countval=$this->ThisModel->count('PCHEADER');
		$data['pcheaderval'] = $val;
		$data['totalpage']=ceil($countval/$page);//总条数
		returnAjax($data,1);
	}

	//后台导航配置取消展示

	public function phc_cancelshow(){
		
	}

	//后台导航配置删除
	public function phc_del(){
		$request = request()->post();
		
		if (empty($request['id'])) {
			returnAjax('参数错误！','0');
		}

		$where['ID']=$request['id'];
		$res=$ThisModel->dele('SHOP_PCHEADER',$where);

		if ($res) {
			returnAjax('删除成功！','1');
		}

	}

	//后台导航配置修改
	public function phc_update(){
		$request = request()->post();
		//判断是否有参数
		if (!empty($request)) {
			if (empty($request['name'])) {
				returnAjax('导航名称不能为空！','0');
			}

			if (empty($request['url'])) {
				returnAjax('导航连接不能为空！','0');
			}

			if (empty($request['id'])) {
				returnAjax('导航id不能为空！','0');	
			}

			$where['ID']=$request['id'];
			$insert['NAME']=$request['name'];
			$insert['URL']=$request['url'];
			$insert['SORTNUM']=(int)$request['sortnum'];

			$res=$ThisModel->upd('SHOP_PCHEADER',$where,$insert);

			if ($res) {
				returnAjax('添加成功!','1');
			}else{
				returnAjax('添加失败',0);
			}

		}else{
			returnAjax('参数错误！','0');
		}
	}
	
}
 