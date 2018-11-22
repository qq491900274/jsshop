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

    //添加或修改教师
    public function update_teacher(){
      $request = request()->post();
      if (!empty($request)) {
        $time=date('Y-m-d H:i:s');
        $data=['NAME'=>$request['name'],
              'CODE'=>$request['code'],
              'SCHOOL'=>$request['school_id'],
              'SCHOOL_ADDRESS'=>$request['school_address'],
              'INTRO'=>$request['intro'],
              'PIC'=>$request['pic'],
              'DATE'=>$time
              ];

        if (!empty($request['id'])) {
          $isok=DB::table('SHOP_TEACHER')
              ->where('ID',$request['id'])
              ->update($data);
        }else{
          $data['ID']=uniqid();
          $isok=DB::table('SHOP_TEACHER')
              ->insert($data);
        }

        echo '1';exit();
      }

      return $this->fetch('update_teacher');
    }
    //返回教师列表页面数据
    public function get_teacherval(){
      $minpage = 0;
      $maxpage = 0;
      $request = request()->post();

      $this->pmodel =  new \app\admin\model\PublicModel();
 
      $where='1=1';
      if(!empty($request['where']['name'])){
        $where .= " and NAME LIKE '%{$request['where']['name']}%'";
      }
      if(!empty($request['where']['code'])) {
        $where .= " and CODE LIKE '%{$request['where']['code']}%'";
      }
      if(!empty($request['where']['school_id'])){
        $where .= " and SCHOOL like '{$request['where']['school_id']}'";
      }
      if(!empty($request['where']['subject_id'])){
        $where .= " and SUBJECT like '{$request['where']['subject_id']}'";
      }
      if(!empty($request['id'])){
        $where .= " and ID='{$request['id']}'";
      }

      //获取post当前页数。与查询条件。
      $maxpage = empty($request['page'])?'19':20*$request['page']-1;
      $minpage = $maxpage-19;
      
      $count=$this->pmodel->select('SHOP_TEACHER','count(ID) num',$where)[0]['num'];
      //获取查询条件
      $where .= " LIMIT {$minpage},{$maxpage}";
      
      $key = "t.ID,NAME,CODE,SUBJECT,s.SCHOOL_NAME SCHOOL,SCHOOL_ADDRESS,INTRO,PIC,DATE";
      $result['value'] = $this->pmodel->select('SHOP_TEACHER as t left join SHOP_SCHOOL as s ON t.SCHOOL=s.ID',$key,$where);
      $result['page'] = empty($request['page']) ? '1' : $request['page'];
      
      $result['allCount'] = ceil($count/20);
      //返回校区数据
      return $result;
    }
    //删除教师
    public function dele_teacher(){
      $this->pmodel =  new \app\admin\model\PublicModel();

      $request = request()->post();
      $id=str_replace(',', "','", $request['id']);
      if (empty($id)) {
        return;
      }
      $where=" ID IN ('{$id}')";
      $isok=$this->pmodel->dele('SHOP_TEACHER',$where);
      
      return '1';
      
    }
    //f
    public function get_schoolval(){
      $request = request()->post();
      $this->pmodel =  new \app\admin\model\PublicModel();
      $where='';
      if ($request['area']) {
        $where=" AREA='{$request['area']}'";
      }
      return $result = $this->pmodel->select('SHOP_SCHOOL',"ID,SCHOOL_NAME",$where);
    }
    //返回教师列表页的科目
    public function get_subjectval(){
      $request = request()->post();
      $this->pmodel =  new \app\admin\model\PublicModel();
      $where="TYPE='2'";
     
      return $result = $this->pmodel->select('SHOP_SUBJECT',"ID,NAME",$where);
    }

    //添加修改教师
    public function update_teachers(){
      
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

      $maxpage = empty($request['page'])?'19':20*$request['page']-1;
      $minpage = $maxpage-19;
      
      //获取查询条件
      $where = "1=1";

      //条件
      if(!empty($request['where']['PROVINCE'])){
        $where .= " and PROVINCE LIKE '%{$request['where']['PROVINCE']}%'";
      }
      if(!empty($request['where']['CITY'])) {
        $where .= " and CITY LIKE '%{$request['where']['CITY']}%'";
      }
      if(!empty($request['where']['AREA'])){
        $where .= " and AREA LIKE '%{$request['where']['AREA']}%'"; 
      }
      if(!empty($request['where']['PHONE'])){
        $where .= " and PHONE='{$request['where']['PHONE']}'";
      }
      if(!empty($request['where']['SCHOOL_NAME'])){
        $where .= " and SCHOOL_NAME like '%{$request['where']['SCHOOL_NAME']}%'";
      }
      if(!empty($request['id']) && $request['id']!=' '){
        $where .= " and id = '{$request['id']}'";
      }

      $where1=$where." LIMIT {$minpage},{$maxpage}";
     
      $key = "ID,PROVINCE,CITY,AREA,ADDRESS,SCHOOL_NAME,PHONE,ADMIN_NAME";
      $result['value'] = $this->pmodel->select('SHOP_SCHOOL',$key,$where1);
      $result['allCount'] = ceil($this->pmodel->select('SHOP_SCHOOL','count(ID) num ',$where)[0]['num'] / 20);
      //返回校区数据
      return $result;
    }
    
    public function delete_school(){
      $request = request()->post();
      $this->pmodel =  new \app\admin\model\PublicModel();
      str_replace(',', "','", $request['id']);
      $where = "ID IN ('{$request['id']}')";
      $isok=$this->pmodel->dele('SHOP_SCHOOL',$where);
      echo '1';
    }
    public function add_school(){
      $request = request()->post();
      
      if (!empty($request)) {
        $time=date('Y-m-d H:i:s');
        $data=['SCHOOL_NAME'=>$request['name'],
              'PROVINCE'=>$request['province'],
              'CITY'=>$request['city'],
              'AREA'=>$request['area'],
              'ADDRESS'=>$request['school_address'],
              'PHONE'=>$request['phone']
              ];
        if (!empty($request['id'])) {
          $isok=DB::table('SHOP_SCHOOL')
              ->where('ID',$request['id'])
              ->update($data);
              return 1;
        }else{
          $data['ID']=uniqid();
          $isok=DB::table('SHOP_SCHOOL')
              ->insert($data);
              return 1;
        }
      }
      

      return $this->fetch('add_school');
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

    //课程列表页面
    public function Lesson_list()
    {

      return $this->fetch('Lesson_list');
    }
    //返回课程列表
    public  function get_curriculum(){
      $minpage = 0; 
      $maxpage = 0;
      $request = request()->post();
      $this->pmodel =  new \app\admin\model\PublicModel();

      //获取post当前页数。与查询条件。
      $maxpage = empty($request['page'])?'19':20*$request['page']-1;
      $minpage = $maxpage-19;
      $where='';
      if ($request['name']) {
        $where.="NAME='{$request['name']}'";
      }
      if ($request['name']) {
        $where.="NAME='{$request['name']}'";
      }
      if ($request['name']) {
        $where.="NAME='{$request['name']}'";
      }
      if ($request['name']) {
        $where.="NAME='{$request['name']}'";
      }
      if ($request['name']) {
        $where.="NAME='{$request['name']}'";
      }
      if ($request['name']) {
        $where.="NAME='{$request['name']}'";
      }
      if ($request['name']) {
        $where.="NAME='{$request['name']}'";
      }

      //获取查询条件
      $where .= " LIMIT {$minpage},{$maxpage}";
      $key = "`ID`, `NAME`, `CODE`, `PRICE`, `CLASSGUID`, `SUBJECTGUID`, `CLASSTYPEGUID`, `TEACHERGUID`, `DATETIME`, `ORDERINDEX`, ".
              "`CONTENT`, `PROVINCE`, `CITY`, `AREA`, `ADDRESS`";
      $result['value'] = $this->pmodel->select('SHOP_CURRICULUM',$key,$where);
      $result['allCount']=ceil($this->pmodel->select('SHOP_CURRICULUM','count(ID) num',$where)[0]['num'] / 20);
      //返回校区数据
      return $result;
    }
    
    //修改课程页
    public function Lesson_edit()
    {
      $request = request()->post();
      if ($request) {
          
      }
      return $this->fetch('Lesson_edit');
    }
    //年级
    public function school_class(){
      return $this->fetch('school_class');
    }
    public function addSchool_class(){
      return $this->fetch('addschool_class');
    }
    public function school_classList(){
      $minpage = 0; 
      $maxpage = 0;
      $request = request()->post();
      $this->pmodel =  new \app\admin\model\PublicModel();

      //获取post当前页数。与查询条件。
      $maxpage = empty($request['page'])?'19':20*$request['page']-1;
      $minpage = $maxpage-19;
      
      //获取查询条件
      $where = "TYPE='1' LIMIT {$minpage},{$maxpage}";
      $key = "ID,NAME";
      $result['value'] = $this->pmodel->select('SHOP_SUBJECT',$key,$where);
      $result['allCount'] = ceil($this->pmodel->select('SHOP_SUBJECT','count(ID) num ',$where)[0]['num'] / 20);
      //返回校区数据
      return $result;
    }
    //删除年级科目功能
    public function delete_classSubject(){
      $request = request()->post();
      $this->pmodel =  new \app\admin\model\PublicModel();
      str_replace(',', "','", $request['id']);
      $where = "ID IN ('{$request['id']}')";
      $isok=$this->pmodel->dele('SHOP_SUBJECT',$where);
      echo '1';
    }
   //科目
    public function subject(){
      return $this->fetch('subject');
    }
    public function add_subject(){
      return $this->fetch('add_subject');
    }
    public function subject_list(){
      $minpage = 0; 
      $maxpage = 0;
      $request = request()->post();
      $this->pmodel =  new \app\admin\model\PublicModel(); 

      //获取post当前页数。与查询条件。
      
      $maxpage = empty($request['page'])?'19':20*$request['page']-1;
      $minpage = $maxpage-19;
      
      //获取查询条件
      $where = "TYPE='2' LIMIT {$minpage},{$maxpage}";
      $key = "ID,NAME";
      $result['value'] = $this->pmodel->select('SHOP_SUBJECT',$key,$where);
      $num=$this->pmodel->select('SHOP_SUBJECT','count(ID) num ',$where);
      if ($num) {
        $result['allCount'] = ceil($num[0]['num'] / 20);
      }
      //返回校区数据
      return $result;
    }

}
