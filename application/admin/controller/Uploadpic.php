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

      if(($_FILES["pic"]["type"]=="image/png"||$_FILES["pic"]["type"]=="image/jpg"||$_FILES["pic"]["type"]=="image/jpeg")&&$_FILES["pic"]["size"]<1024000)
      {       
        $file=time().'.jpg';
        //防止文件名重复
        $filename =ROOT_PATH.'public'.DS."uploads/".time().'.jpg';

        //转码，把utf-8转成gb2312,返回转换后的字符串， 或者在失败时返回 FALSE。
        $filename =iconv("UTF-8","gb2312",$filename);
         //检查文件或目录是否存在
        if(file_exists($filename))
        {
            echo"该文件已存在";
        }
        else
        {  
            //保存文件,   move_uploaded_file 将上传的文件移动到新位置  
            move_uploaded_file($_FILES["pic"]["tmp_name"],$filename);//将临时地址移动到指定地址    
            return json_encode(array('src'=>BASE_URL.'/public/uploads/'.$file));
        }        
      }
      else
      {
          echo"文件类型不对";
      }
     
    }

    function config_pic(){
      return $this->fetch('config_pic');
    }
}
