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
        $where .= " and t.ID='{$request['id']}'";
      }

      //获取post当前页数。与查询条件。
      $maxpage = empty($request['page'])?'19':20*$request['page']-1;
      $minpage = $maxpage-19;
      
      $count=$this->pmodel->select('SHOP_TEACHER t','count(ID) num',$where)[0]['num'];
      //获取查询条件
      $where .= " LIMIT {$minpage},{$maxpage}";
      
      $key = "t.ID,NAME,CODE,SUBJECT,s.SCHOOL_NAME SCHOOL,s.ID SCHOOLID,SCHOOL_ADDRESS,INTRO,PIC,DATE";
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
      $request['area']=empty($request['area']) ? '' : $request['area'];
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

      if(!empty($request['area'])){
        $where=" AREA='{$request['area']}'";
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
    //添加修改学校
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
      $where="C.ID!=''";
      //课程名字
      if (!empty($request['where']['name'])) {
        $where=empty($where) ? '' : $where.' and ';
        $where.="C.NAME='{$request['where']['name']}'";
      }
      //课程编号
      if (!empty($request['where']['code'])) {
        $where=empty($where) ? '' : $where.' and ';
        $where.="C.CODE='{$request['where']['code']}'";
      }
      //班形
      if (!empty($request['where']['lessonType'])) {
        $where=empty($where) ? '' : $where.' and ';
        $where.="C.CLASSTYPEGUID='{$request['where']['lessonType']}'";
      }
      //班级
      if (!empty($request['where']['grade'])) {
        $where=empty($where) ? '' : $where.' and ';
        $where.="C.CLASSGUID='{$request['where']['grade']}'";
      }
      //校区
      if (!empty($request['where']['school_id'])) {
        $where=empty($where) ? '' : $where.' and ';
        $where.="C.SCHOOLID='{$request['where']['school_id']}'";
      }
      //科目
      if (!empty($request['where']['subjects'])) {  
        $where=empty($where) ? '' : $where.' and ';
        $where.="C.SUBJECTGUID='{$request['where']['subjects']}'";
      }
      //教师
      if (!empty($request['where']['teacher'])) {
        $where=empty($where) ? '' : $where.' and ';
        $where.="C.TEACHERGUID='{$request['where']['teacher']}'";
      }
     
      //获取查询条件
      $where .= " LIMIT {$minpage},{$maxpage}";

      $key = "C.ID,C.COUNT, C.NAME, C.CODE, C.PRICE, C.CLASSGUID GRADE, SUBJECTGUID SUBJECT, ".
              "C.CLASSTYPEGUID LESSON_TYPE,T.NAME TEACHER, DATETIME, ORDERINDEX, ".
              "CONTENT, C.PROVINCE, C.CITY, C.AREA,S.SCHOOL_NAME,T.PIC TEACHERIMG";
      $table='SHOP_CURRICULUM C '.
              ' LEFT JOIN SHOP_SCHOOL S ON S.ID=C.SCHOOLID'.
              ' LEFT JOIN SHOP_TEACHER T ON T.ID=C.TEACHERGUID';

      $value= $this->pmodel->select($table,$key,$where);
      //获取年级科目
      $subjectval=$this->pmodel->select('SHOP_SUBJECT','ID,NAME');
      $subjectv=array();
      foreach ($subjectval as $k => $v) {
         $subjectv[$v['ID']]=$v['NAME'];
      }

      foreach ($value as $key => $v) {
        if (!empty($subjectv[$v['GRADE']])) {
           $value[$key]['GRADE']=$subjectv[$v['GRADE']];//年级
        }
       if (!empty($subjectv[$v['SUBJECT']])) {
            $value[$key]['SUBJECT']=$subjectv[$v['SUBJECT']];//科目
        }
        $value[$key]['DATETIME']=DATE('Y-m-d H:i:s',strtotime($v['DATETIME']));
      }

      $result['value']=$value;
      $result['allCount']=ceil($this->pmodel->select('SHOP_CURRICULUM C','count(C.ID) num',$where)[0]['num'] / 20);
      //返回校区数据
      return $result;
    }
    //根据id获取课程
    public function getcurriculum(){
      $this->pmodel =  new \app\admin\model\PublicModel();
      $request = request()->post();
       //根据id搜索
      if (empty($request['id'])) {
        return '未获取到id';
      }

      $where="ID='{$request['id']}'";
      $key = "ID, NAME, CODE,COUNT, PRICE, CLASSGUID, SUBJECTGUID,SEASONTYPE,".
              "CLASSTYPEGUID,NAME, DATETIME, ORDERINDEX, SEMESTER,STARTTIME,ENDTIME,".
              "CONTENT, PROVINCE, CITY, AREA,SCHOOLID,COURSENUM,COURSETIME,TEACHERGUID,IMG";
      $table='SHOP_CURRICULUM ';

      return $value['value']= $this->pmodel->select($table,$key,$where);
    }
    //修改课程页
    public function Lesson_edit()
    {
      $request = request()->post();
      if (empty($request)) {
        return $this->fetch('Lesson_edit');
      }
      
      $request['name']=empty($request['name'])?'':$request['name'];
      $request['code']=empty($request['code'])?'':$request['code'];
      $request['price']=empty($request['price'])?'':$request['price'];
      $request['gradeid']=empty($request['gradeid'])?'':$request['gradeid'];
      $request['subjectsid']=empty($request['subjectsid'])?'':$request['subjectsid'];
      $request['lessonTypeid']=empty($request['lessonTypeid'])?'':$request['lessonTypeid'];
      $request['teacherid']=empty($request['teacherid'])?'':$request['teacherid'];
      $request['num']=empty($request['num'])?'':$request['num'];
      $request['intro']=empty($request['intro'])?'':$request['intro'];
      $request['province']=empty($request['province'])?'':$request['province'];
      $request['city']=empty($request['city'])?'':$request['city'];
      $request['area']=empty($request['area'])?'':$request['area'];
      $request['schoolid']=empty($request['schoolid'])?'':$request['schoolid'];
      $request['classTypeid']=empty($request['classTypeid'])?'':$request['classTypeid'];
      $request['semester']=empty($request['semester'])?'':$request['semester'];
      $request['startTime']=empty($request['startTime'])?'':$request['startTime'];
      $request['endTime']=empty($request['endTime'])?'':$request['endTime'];
      $request['lessonNum']=empty($request['lessonNum'])?'':$request['lessonNum'];
      $request['lessonTime']=empty($request['lessonTime'])?'':$request['lessonTime'];
      $request['img']=empty($request['img'])?'':$request['img'];

      $sql=[
        'NAME'=>$request['name'],
        'CODE'=>$request['code'],
        'PRICE'=>$request['price'],
        'CLASSGUID'=>$request['gradeid'],
        'SUBJECTGUID'=>$request['subjectsid'],
        'CLASSTYPEGUID'=>$request['lessonTypeid'],
        'TEACHERGUID'=>$request['teacherid'],
        'DATETIME'=>date('Y-m-d H:i:s'),
        'ORDERINDEX'=>$request['num'],
        'CONTENT'=>$request['intro'],
        'PROVINCE'=>$request['province'],
        'CITY'=>$request['city'],
        'AREA'=>$request['area'],
        'SCHOOLID'=>$request['schoolid'],
        'SEASONTYPE'=>$request['classTypeid'],
        'SEMESTER'=>$request['semester'],
        'STARTTIME'=>$request['startTime'],
        'ENDTIME'=>$request['endTime'],
        'COURSENUM'=>$request['lessonNum'],
        'COURSETIME'=>$request['lessonTime'],
        'IMG'=>$request['img'],
        'COUNT'=>$request['count']
      ];

      if (!empty($request['id'])) {
        $isok=DB::table('SHOP_CURRICULUM')
            ->where('ID',$request['id'])
            ->update($sql);
      }else{
        $sql['ID']=uniqid();
        $isok=DB::table('SHOP_CURRICULUM')->insert($sql);
      }

      echo '1';
    }
    //删除课程
    function dele_curriculum(){
      $request = request()->post();
      $this->pmodel =  new \app\admin\model\PublicModel();
     
      $where = "ID = '{$request['id']}'";
      $isok=$this->pmodel->dele('SHOP_CURRICULUM',$where);

      return 1;
    }
    //年级
    public function school_class(){
      return $this->fetch('school_class');
    }
    //修改年级
    public function addSchool_class(){
      $request = request()->post();
      if (empty($request)) {
        return $this->fetch('addschool_class');
      }

      $request = request()->post();
     
      $sql=['NAME'=>$request['name'],
            'SUBJECTID'=>$request['checkedId'],
            'TYPE'=>'1'];

      if (!empty($request['id'])) {
        $isok=DB::table('SHOP_SUBJECT')
            ->where('ID',$request['id'])
            ->update($sql);
      }else{
        $sql['ID']=uniqid();
        $isok=DB::table('SHOP_SUBJECT')->insert($sql);
      }
      echo '1';
    }
    //年级
    public function school_classList(){
      $minpage = 0; 
      $maxpage = 0;
      $request = request()->post();
      $this->pmodel =  new \app\admin\model\PublicModel();
      $where='';
      if(!empty($request['id'])){
        $where=" ID='{$request['id']}' and ";
      }

      //获取post当前页数。与查询条件。
      $maxpage = empty($request['page'])?'19':20*$request['page']-1;
      $minpage = $maxpage-19;
      
      //获取查询条件
      $where .= "TYPE='1' LIMIT {$minpage},{$maxpage}";

      $key = "ID,NAME,SUBJECTID";
      $result['value'] = $this->pmodel->select('SHOP_SUBJECT',$key,$where);

      if (!empty($request['id'])) {
        foreach ($result['value'] as $key => $value) {
          if (empty($value['SUBJECTID'])) {
            continue;
          }

          $where1=str_replace(',', "','", $value['SUBJECTID']);
          $where1=" ID in ('{$where1}')";
          $subjectid=$this->pmodel->select('SHOP_SUBJECT','ID,NAME',$where1);

          if (empty($subjectid)) {
            continue;
          }

          foreach ($subjectid as $value) {
            $subjcetarr[]=$value['ID'];
          }

          $result['value'][$key]['SUBJECTID']=$subjcetarr;
        }
      }
      
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
    //修改科目
    public function add_subject(){
      $request = request()->post();
      
      if (empty($request)) {
        return $this->fetch('add_subject');
      }

      $sql=['NAME'=>$request['name'],'TYPE'=>'2'];

      if (!empty($request['id'])) {
        $isok=DB::table('SHOP_SUBJECT')
            ->where('ID',$request['id'])
            ->update($sql);
      }else{
        $sql['ID']=uniqid();
        $isok=DB::table('SHOP_SUBJECT')->insert($sql);
      }
      return 1;
    }
    //科目列表
    public function subject_list(){
      $minpage = 0; 
      $maxpage = 0;
      $request = request()->post();
      $this->pmodel =  new \app\admin\model\PublicModel(); 

      //获取post当前页数。与查询条件。
      $where='';
      if(!empty($request['id'])){
        $where=" ID='{$request['id']}' and ";
      }

      $maxpage = empty($request['page'])?'19':20*$request['page']-1;
      $minpage = $maxpage-19;
      
      //获取查询条件
      $where.= "TYPE='2' LIMIT {$minpage},{$maxpage}";
      $key = "ID,NAME";
      $result['value'] = $this->pmodel->select('SHOP_SUBJECT',$key,$where);
      $num=$this->pmodel->select('SHOP_SUBJECT','count(ID) num ',$where);
      if ($num) {
        $result['allCount'] = ceil($num[0]['num'] / 20);
      }
      //返回校区数据
      return $result;
    }
    //首页配置
    public function index_config(){
      $request = request()->post();
      $this->pmodel =  new \app\admin\model\PublicModel(); 
      //获取默认数据
      if (!empty($request['list']) && $request['list']=='1') {

        $key = "ID,PHONE,PHONE1";
        $value = $this->pmodel->select('SHOP_SLIDESHOW',$key);

        if (!empty($value)) {
           //查询轮播图
           $key=" ID,PICURL imgUrl,URL imgHref,ORDERINDEX num";
           $where=" TYPE='bannerLis'";
           $value[0]['bannerLis'] = $this->pmodel->select('SHOP_SLIDESHOWPIC',$key,$where);
           $where=" TYPE='imgLis'";
           $value[0]['imgLis'] = $this->pmodel->select('SHOP_SLIDESHOWPIC',$key,$where);
           $where=" TYPE='hotLis'";
           $value[0]['hotLis'] = $this->pmodel->select('SHOP_SLIDESHOWPIC',$key,$where);

           return $value[0];
        }
      }
      return $this->fetch('index_config');
    }

    public function insert_index(){
      $request = request()->post();
      $this->pmodel =  new \app\admin\model\PublicModel(); 

      if (!empty($request)) {
       
        //获取关联ID
        $slideshowID=$this->pmodel->select('SHOP_SLIDESHOW','ID');
        if (empty($slideshowID[0]['ID'])) {
          $sql1['ID']=uniqid();
          $sql1['PHONE']=$request['hotPhone'];
          $sql1['PHONE1']=$request['majorPhone'];

          $isok=DB::table('SHOP_SLIDESHOW')
            ->insert($sql1);

          $slideshowID=$sql1['ID'];
        }else{
          $slideshowID=$slideshowID[0]['ID'];
          //修改操作

          $sql1['PHONE']=$request['hotPhone'];
          $sql1['PHONE1']=$request['majorPhone'];

          $isok=DB::table('SHOP_SLIDESHOW')
            ->where('ID',$slideshowID)
            ->update($sql1);
        }

        if (!empty($request['bannerLis'])) {
          foreach ($request['bannerLis'] as $key => $value) {
            if (empty($value['ID'])) {
              
                $bannerLissql['ID']=uniqid();
                $bannerLissql['TYPE']='bannerLis';
                $bannerLissql['PICURL']=$value['imgUrl'];
                $bannerLissql['URL']=$value['imgHref'];
                $bannerLissql['ORDERINDEX']=$value['num'];
                $bannerLissql['SLDESHOWID']=$slideshowID;
                $isok=DB::table('SHOP_SLIDESHOWPIC')
                ->insert($bannerLissql);
            }
          }
        }
        
        if (!empty($request['hotLis'])) {
          foreach ($request['hotLis'] as $key => $value) {
            if (empty($value['ID'])) {
                $hotLissql['ID']=uniqid();
                $hotLissql['PICURL']=$value['imgUrl'];
                $hotLissql['URL']=$value['imgHref'];
                $hotLissql['ORDERINDEX']=$value['num'];
                $hotLissql['TYPE']='hotLis';
                $hotLissql['SLDESHOWID']=$slideshowID;
                $isok=DB::table('SHOP_SLIDESHOWPIC')
                ->insert($hotLissql);
            }
          }
        }
        
        if (!empty($request['imgLis'])) {
          foreach ($request['imgLis'] as $key => $value) {
            if (empty($value['ID'])) {
                $imgLissql['ID']=uniqid();
                $imgLissql['TYPE']='imgLis';
                $imgLissql['PICURL']=$value['imgUrl'];
                $imgLissql['URL']=$value['imgHref'];
                $imgLissql['ORDERINDEX']=$value['num'];
                $imgLissql['SLDESHOWID']=$slideshowID;
                $isok=DB::table('SHOP_SLIDESHOWPIC')
                ->insert($imgLissql);
            }
          }
        }
        
        echo "1";

      }

    }
    //修改图片 
    public function update_index(){
      $request = request()->post();
      $this->pmodel =  new \app\admin\model\PublicModel(); 
      $sql=[
          'PICURL'=>$request['picurl'],
          'URL'=>$request['url'],
          'ORDERINDEX'=>$request['orderindex'],
        ];
      $isok=DB::table('SHOP_SLIDESHOWPIC')
            ->where('ID',$request['id'])
            ->update($sql);
      echo '1';
    }
    public function dele_config(){
      $request = request()->post();
      $this->pmodel =  new \app\admin\model\PublicModel();
      
      $where = "ID = '{$request['id']}'";
      $isok=$this->pmodel->dele('SHOP_SLIDESHOWPIC',$where);
      echo '1';
    }
    //课堂类型
    public function type(){
      $minpage = 0; 
      $maxpage = 0;
      $request = request()->post();
      $this->pmodel =  new \app\admin\model\PublicModel(); 
      
      if ($Request['list']=='1') {
        //获取post当前页数。与查询条件。
        $where='';
        if(!empty($request['id'])){
          $where=" ID='{$request['id']}' and ";
        }

        $maxpage = empty($request['page'])?'19':20*$request['page']-1;
        $minpage = $maxpage-19;
        
        //获取查询条件
        $where.= "TYPE='2' LIMIT {$minpage},{$maxpage}";
        $key = "ID,NAME";
        $result['value'] = $this->pmodel->select('SHOP_CURRICULUM_TYPE',$key,$where);
        $num=$this->pmodel->select('SHOP_CURRICULUM_TYPE','count(ID) num ',$where);
        if ($num) {
          $result['allCount'] = ceil($num[0]['num'] / 20);
        }
        //返回校区数据
        return $result;
      }
      return $this->fetch('type');
    }
   
    //修改添加课程
    public  function add_type(){
      $request = request()->post();
      
      if (empty($request)) {
        return $this->fetch('add_subject');
      }

      $sql=['NAME'=>$request['name']];

      if (!empty($request['id'])) {
        $isok=DB::table('SHOP_CURRICULUM_TYPE')
            ->where('ID',$request['id'])
            ->update($sql);
      }else{
        $sql['ID']=uniqid();
        $isok=DB::table('SHOP_CURRICULUM_TYPE')->insert($sql);
      }
      return 1;
    }

    //删除课程类型
    public function dele_currtype(){
      $request = request()->post();
      $this->pmodel =  new \app\admin\model\PublicModel();
      
      $where = "ID = '{$request['id']}'";
      $isok=$this->pmodel->dele('SHOP_CURRICULUM_TYPE',$where);
      echo '1';
    }
}
 