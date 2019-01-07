<?php
namespace app\index\controller;
use think\mobile_controller;
use think\View;
use think\Request;
use think\Session;

use \think\Db;


class Lesson extends mobile_controller
{	
	public function __construct(){
		parent::__construct();
	}
	
    public function index(){
    	$Request=request()->post();
		$this->pmodel =  new \app\index\model\PublicModel(); 

		if (!empty($Request['list'])&& $Request['list']=='1') {
	        $where = "TYPE='1'";

	        $key = "ID,NAME,SUBJECTID";
	        $result['value'] = $this->pmodel->select('SHOP_SUBJECT',$key,$where);
	       	//返回年级科目关联数组
            foreach ($result['value'] as $key => $value) {
                if (empty($value['SUBJECTID'])) {
               		 continue;
                }

          		$where1=str_replace(',', "','", $value['SUBJECTID']);
          		$where1=" ID in ('{$where1}')";
          		$result['value'][$key]['SUBJECTID']=$this->pmodel->select('SHOP_SUBJECT','ID,NAME',$where1);

          		if (empty($subjectid)) {
            		continue;
          		}
            }
	        
			return $result;
		}

    	return $this->fetch('lesson'); 
    }


     public function lesson_show()
    {
      return $this->fetch('lesson_show');
    }


    //返回符合条件的课程
    function get_class(){
    	$Request=request()->post();
		$this->pmodel =  new \app\index\model\PublicModel(); 
		$where='1=1 ';

		if (!empty($Request['school'])) {
			$where.=" and SCHOOLID='{$Request['school']}'";
		}

		if (!empty($Request['class'])) {
			$where.=" and CLASSGUID='{$Request['class']}'";
		}

		if (!empty($Request['subject'])) {
			$where.=" and SUBJECTGUID='{$Request['subject']}'";
		}

		if (!empty($Request['classtypeguid'])) {
			$where.=" and CLASSTYPEGUID='{$Request['classtypeguid']}'";
		}
		
		$key='C.ID,C.NAME,C.CODE,C.PRICE,C.DATETIME,C.CONTENT,C.SEASONTYPE,'.
			'C.STARTTIME,C.ENDTIME,C.COURSENUM,C.COURSETIME,C.IMG,C.COUNT,'.
			'T.NAME TEACHERNAME,T.PIC,C.CLASSINFOR';
		$table='SHOP_CURRICULUM as C LEFT  JOIN SHOP_TEACHER T ON T.ID=C.TEACHERGUID';
		$data=$this->pmodel->select($table,$key,$where);
		return $data;
    }

    //返回课堂类型
    function get_classtype(){
    	$Request=request()->post();
		$this->pmodel =  new \app\index\model\PublicModel(); 
    	$key='ID,NAME';
		$data=$this->pmodel->select('SHOP_CURRICULUM_TYPE',$key);
		return $data;
    }
    
    //获取课程详情
    function get_lesson(){
    	$Request=request()->post();
		$this->pmodel =  new \app\index\model\PublicModel(); 

    	if (!empty($Request['id'])) {
    		$where="C.ID='{$Request['id']}'";
    		$key='C.ID,C.NAME,C.CODE,C.PRICE,C.DATETIME,C.CONTENT,C.SEASONTYPE,'.
    			'C.STARTTIME,C.ENDTIME,C.COURSENUM,C.COURSETIME,C.IMG,C.COUNT,'.
    			'T.NAME TEACHERNAME,T.CODE,T.SUBJECT,T.INTRO,T.PIC,T.DATE,'.
    			'S.PROVINCE,S.CITY,S.AREA,S.SCHOOL_NAME,S.ADDRESS,S.PHONE';
    		$table='SHOP_CURRICULUM as C '.
    			'left join SHOP_TEACHER as T on T.ID=C.TEACHERGUID '.
    			'left join SHOP_SCHOOL as S on S.ID=C.SCHOOLID ';
    		
			return $data=$this->pmodel->select($table,$key,$where);
    	}
    }

    //添加购物车功能
    function add_cart(){
    	$Request=request()->post();

    	foreach ($Request['date'] as $key => $value) {
    		$data['CURRICULUMID']=$value['id'];
	    	$data['USERID']=$value['userid'];
	    	$data['DATETIME']=date('Y-m-d H:i:s');
	    	$data['ID']=uniqid();
	    	$data['NUM']=$value['num'];
	    	$data['COUNPONID']=$value['couponid'];
	    	Db::table('SHOP_CART')->insert($data);
    	}

    	return 1;
    }
    //删除购物车
    function del_cart(){
    	$Request=request()->post();
    	Db::table('SHOP_CART')->where('ID',$Request['id'])->delete();
    	return 1;
    }
   
}
