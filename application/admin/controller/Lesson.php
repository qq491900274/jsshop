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
      $result['value'] = $this->pmodel->select('SHOP_TEACHER',$key,$where);
      $result['page'] = empty($request['page']) ? '1' : $request['page'];
      $result['count'] = $this->pmodel->select('SHOP_TEACHER','count(ID)','');
      //返回校区数据
      return $result;
    }
    //删除教师
    public function dele_teacher(){
      $request = request()->post();
      $isok=DB::table('SHOP_TEACHER')
            ->where('ID',$request['id'])
            ->delete();

      if($isok){
        return '1';
      }
    }
    //添加修改教师
    public function update_teacher(){
      $request = request()->post();
      
      $data=['NAME'=>$request['name'],
            'CODE'=>$request['code'],
            'SCHOOL'=>$request['school'],
            'SCHOOL_ADDRESS'=>$request['school_address'],
            'INTRO'=>$request['intro'],
            'PIC'=>$request['pic'],
            'DATE'=>$request['date']
            ];
      if (empty($request['id'])) {
        $isok=DB::table('SHOP_TEACHER')
            ->where('ID',$request['id'])
            ->update($data);
      }else{
        $isok=DB::table('SHOP_TEACHER')
            ->insert($data);
      }

      if($isok){
        return '1';
      }
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

      $result = $this->pmodel->select('SHOP_SCHOOL',"ID,SCHOOL_NAME",$where);
      return $result;
    }
    
    //校区列表页面
    public function Lesson_school()
    {
      return $this->fetch('Lesson_school');
    }
    //返回校区列表
    public function get_schoollist(){
      $minpage = 0; 
      $maxpage = 0;
      $request = request()->post();
      $this->pmodel =  new \app\admin\model\PublicModel();

      //获取post当前页数。与查询条件。
      $maxpage = empty($request['page'])?'20':20*$request['page']-1;
      $minpage = $maxpage-20;
      
      //获取查询条件
      $where = "ID!='' LIMIT {$minpage},{$maxpage}";
      $key = "ID,PROVINCE,CITY,AREA,ADDRESS,SCHOOL_NAME,PHONE,ADMIN_NAME";
      $result = $this->pmodel->select('SHOP_SCHOOL',$key,$where);

      //返回校区数据
      return $result;
    }

    //添加修改校区 
    public function update_school(){
      $request = request()->post();
      
      $sql=['PROVINCE'=>$request['name'],
            'CITY'=>$request['code'],
            'AREA'=>$request['school'],
            'SCHOOL_NAME'=>$request['school_address'],
            'PHONE'=>$request['intro'],
            'ADMIN_NAME'=>$request['pic']
            ];

      if (empty($request['id'])) {
        $isok=DB::table('SHOP_SCHOOL')
            ->where('ID',$request['id'])
            ->update($sql);
      }else{
        $isok=DB::table('SHOP_SCHOOL')->insert($sql);
      }

      if($isok){
        return '1';
      }
    }
    //删除校区
    public function dele_school(){
      $request = request()->post();
      $isok=DB::table('SHOP_SCHOOL')
            ->where('ID',$request['id'])
            ->delete();

      if($isok){
        return '1';
      }
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
