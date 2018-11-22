<?php
namespace app\admin\controller;
use think\Controller;
use think\View;
use think\Request;
use think\Session;

use \think\Db;

class Uploadpic extends Controller
{	
	public function __construct(){
		parent::__construct();
	}
      
   function index(){
      $file = request()->file("pic");
      if($file){
            $info = $file->validate(['size'=>5242880,'ext'=>'jpg,png,gif'])->move(ROOT_PATH.'public'.DS.'uploads');
            if($info){
                $arr=json_encode(array('src' => BASE_URL.'/public/uploads/'.$info->getSaveName()));
                return $arr; 
            }else{
                // 上传失败获取错误信息
                return $file->getError();
            }
         }else{
            return "未获取到图片！";
         }
    }
}
