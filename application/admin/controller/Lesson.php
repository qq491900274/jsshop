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
      return $this->fetch('lesson_teacher');uif
    }

    //添加或修改教师
    public function update_teacher(){
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
        $where .= " and NAME LIKE '%{$request['name']}%'";
      }
      if(!empty($request['where']['code'])) {
        $where .= " and CODE LIKE '%{$request['code']}%'";
      }
      if(!empty($request['where']['school_id'])){
        $where .= " and SCHOOL='{$request['school_id']}'";
      }
      if(!empty($request['where']['subject_id'])){
        $where .= " and SUBJECT='{$request['subject_id']}'";
      }

      //获取post当前页数。与查询条件。
      $maxpage = empty($request['page'])?'19':$request['page']*20-1;
      $minpage = $maxpage-19;
      
      //获取查询条件
      $where .= " LIMIT {$minpage},{$maxpage}";

      $key = "ID,NAME,CODE,SUBJECT,SCHOOL,SCHOOL_ADDRESS,INTRO,PIC,DATE";
      $result['value'] = $this->pmodel->select('SHOP_TEACHER',$key,$where);
      $result['page'] = empty($request['page']) ? '1' : $request['page'];
      $count=$this->pmodel->select('SHOP_TEACHER','count(ID) num','')[0]['num'];
      $result['count'] = ceil($count/20);
      //返回校区数据
      return $result;
    }
    //删除教师
    public function dele_teacher(){
      $this->pmodel =  new \app\admin\model\PublicModel();

      $request = request()->post();
      $id=str_replace(',', "','", $request['id']);

      $where=" ID IN ('{$id}')";
      $isok=$this->pmodel->dele('SHOP_TEACHER',$where);
      
      return '1';
      
    }
    //添加修改教师
    public function update_teachers(){
      $request = request()->post();
      $time=date('Y-m-d H:i:s');
      $data=['NAME'=>$request['name'],
            'CODE'=>$request['code'],
            'SCHOOL'=>$request['school'],
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
      $maxpage = empty($request['page'])?'19':19*$request['page']-1;
      $minpage = $maxpage-19;
      
      //获取查询条件
      $where = "ID!='' LIMIT {$minpage},{$maxpage}";
      $key = "ID,PROVINCE,CITY,AREA,ADDRESS,SCHOOL_NAME,PHONE,ADMIN_NAME";
      $result['value'] = $this->pmodel->select('SHOP_SCHOOL',$key,$where);

      //返回校区数据
      return $result;
    }

    public function add_school(){
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
    //删除校区
    public function dele_school(){
      
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
      $request = request()->post();
      if ($request) {
          
      }
      return $this->fetch('Lesson_edit');
    }
    //获取修改课程默认数据
    public function Lesson_editval(){
        return;
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
      return $this->fetch('lesson_teacher');uif
    }

    //添加或修改教师
    public function update_teacher(){
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
        $where .= " and NAME LIKE '%{$request['name']}%'";
      }
      if(!empty($request['where']['code'])) {
        $where .= " and CODE LIKE '%{$request['code']}%'";
      }
      if(!empty($request['where']['school_id'])){
        $where .= " and SCHOOL='{$request['school_id']}'";
      }
      if(!empty($request['where']['subject_id'])){
        $where .= " and SUBJECT='{$request['subject_id']}'";
      }

      //获取post当前页数。与查询条件。
      $maxpage = empty($request['page'])?'19':$request['page']*20-1;
      $minpage = $maxpage-19;
      
      //获取查询条件
      $where .= " LIMIT {$minpage},{$maxpage}";

      $key = "ID,NAME,CODE,SUBJECT,SCHOOL,SCHOOL_ADDRESS,INTRO,PIC,DATE";
      $result['value'] = $this->pmodel->select('SHOP_TEACHER',$key,$where);
      $result['page'] = empty($request['page']) ? '1' : $request['page'];
      $count=$this->pmodel->select('SHOP_TEACHER','count(ID) num','')[0]['num'];
      $result['count'] = ceil($count/20);
      //返回校区数据
      return $result;
    }
    //删除教师
    public function dele_teacher(){
      $this->pmodel =  new \app\admin\model\PublicModel();

      $request = request()->post();
      $id=str_replace(',', "','", $request['id']);

      $where=" ID IN ('{$id}')";
      $isok=$this->pmodel->dele('SHOP_TEACHER',$where);
      
      return '1';
      
    }
    //添加修改教师
    public function update_teachers(){
      $request = request()->post();
      $time=date('Y-m-d H:i:s');
      $data=['NAME'=>$request['name'],
            'CODE'=>$request['code'],
            'SCHOOL'=>$request['school'],
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
      $maxpage = empty($request['page'])?'19':19*$request['page']-1;
      $minpage = $maxpage-19;
      
      //获取查询条件
      $where = "ID!='' LIMIT {$minpage},{$maxpage}";
      $key = "ID,PROVINCE,CITY,AREA,ADDRESS,SCHOOL_NAME,PHONE,ADMIN_NAME";
      $result['value'] = $this->pmodel->select('SHOP_SCHOOL',$key,$where);

      //返回校区数据
      return $result;
    }

    public function add_school(){
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
    //删除校区
    public function dele_school(){
      
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
    public get_curriculum(){
      $minpage = 0; 
      $maxpage = 0;
      $request = request()->post();
      $this->pmodel =  new \app\admin\model\PublicModel();

      //获取post当前页数。与查询条件。
      $maxpage = empty($request['page'])?'19':19*$request['page']-1;
      $minpage = $maxpage-19;
      
      //获取查询条件
      $where = "ID!='' LIMIT {$minpage},{$maxpage}";
      $key = "ID,NAME";
      $result['value'] = $this->pmodel->select('SHOP_CURRICULUM',$key,$where);

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
    //获取修改课程默认数据
    public function Lesson_editval(){
        return;
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
