<?php
namespace app\admin\controller;
use think\Controller;
use think\View;
use think\Request;
use think\Session;

use \think\Db;

class Lesson extends Controller
{	
	public function __construct(){
		parent::__construct();
	}
	
    public function index(){
    	$this->Lesson_teacher();
    }
    //教师列表页
    public function Lesson_teacher()
    {

      return $this->fetch('lesson_teacher');
    }
    //校区列表页面
    public function Lesson_school()
    {
      return $this->fetch('Lesson_school');
    }
    //课程列表页面
    public function Lesson_list()
    {
      return $this->fetch('Lesson_list');
    }
    //修改课程页
    public function Lesson_edit()
    {
      return $this->fetch('Lesson_edit');
    }
    
    //验证密码功能
     function getpwd(){
      $request = request()->post();

      if ($request['user']=='1' && $request['pwd']=='2') {
        return array('msg'=>'登陆成功！','state'=>'1');  
      }else{
        return array('msg'=>'登陆失败！','state'=>'2');
      }

    }
}
