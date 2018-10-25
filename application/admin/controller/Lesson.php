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
    	return $this->Lesson_teacher();
    }
    //教师列表页
    public function Lesson_teacher()
    {
      return $this->fetch('lesson_teacher');
    }

    //返回教师列表页面数据
    public function get_teacherval(){
      $minpage = 0;
      $maxpage = 0;
      $request = request()->post();
      $this->pmodel =  new \app\admin\model\PublicModel();

      //获取post当前页数。与查询条件。
      $maxpage = empty($request['page'])?'20':20*$request['page']-1;
      $minpage = $maxpage-20;
      
      //获取查询条件
      $where = "ID!='' LIMIT {$minpage},{$maxpage}";
      $key = "ID,NAME,CODE,SUBJECT,SCHOOL,SCHOOL_ADDRESS,INTRO,PIC,DATE";
      $result = $this->pmodel->select('SHOP_TEACHER',$key,$where);

      //返回校区数据
      return $result;
    }
    //返回教师列表页的校区数据
    public function get_school(){
      $request = request()->post();
      $this->pmodel =  new \app\admin\model\PublicModel();

      if(!empty($request['province']) && !empty($request['city']) && !empty($request['area'])){
        $where="PROVINCE='{$request['province']}' and CITY='{$request['city']}' and AREA='{$request['area']}'";
      }else{
        return '';exit;
      }

      $result = $this->pmodel->select('SHOP_TEACHER',"ID,NAME",$where);
      return $result;
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
