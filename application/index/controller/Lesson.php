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
		
		if(!empty($Request['name'])){
			$where.="and (C.NAME LIKE '%{$Request['name']}%' or T.NAME LIKE '%{$Request['name']}%')";
		}
		$maxpage = empty($Request['page'])?'4':5*$Request['page']-1;
 		$minpage = $maxpage-4;
		$where.=" limit {$minpage},{$maxpage}";
	
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
    			'C.STARTTIME,C.ENDTIME,C.COURSENUM,C.COURSETIME,C.IMG,C.COUNT,C.TEACHERGUID,'.
    			'T.NAME TEACHERNAME,T.CODE,T.SUBJECT,T.INTRO,T.PIC,T.DATE,'.
    			'S.PROVINCE,S.CITY,S.AREA,S.SCHOOL_NAME,S.ADDRESS,S.PHONE,ST.NAME CLASSNAME,TS.NAME SUBJECTNAME';
    		$table='SHOP_CURRICULUM as C '.
    			'left join SHOP_TEACHER as T on T.ID=C.TEACHERGUID '.
    			'left join SHOP_SCHOOL as S on S.ID=C.SCHOOLID '.
                'left join SHOP_SUBJECT AS ST ON ST.ID=C.CLASSGUID '.
                'left join SHOP_SUBJECT AS TS ON TS.ID=C.SUBJECTGUID';
    		
			return $data=$this->pmodel->select($table,$key,$where);
    	}
    }

    //获取老师所属课程
    function get_teacher(){
        $Request=request()->post();
        $this->pmodel =  new \app\index\model\PublicModel(); 

        if (!empty($Request['id'])) {
            $where="TEACHERGUID='{$Request['id']}'";
            $key='*';
            $table='SHOP_CURRICULUM';
            
            return $data=$this->pmodel->select($table,$key,$where);
        }
    }

    //获取课程报名人数
    function get_num(){
        $Request=request()->post();
        $this->pmodel =  new \app\index\model\PublicModel(); 

        if (!empty($Request['id'])) {
            $where="CURRICULUMID='{$Request['id']}'";
            $key='count(ID) AS NUM ';
            $table='SHOP_ORDERGOODS';
            
            return $data=$this->pmodel->select($table,$key,$where)[0]['NUM'];
        }
    }
    //添加购物车功能
    function add_cart(){
    	$Request=request()->post();

        //判断购物车是否已有商品
        $where['CURRICULUMID']=$Request['id'];
        $where['USERID']=$_SESSION['userid'];
        $ishave=Db::table('SHOP_CART')
                ->where($where)
                ->select();
        if (!empty($ishave)) {
            // $update['NUM']=$Request['num']+$ishave[0]['NUM'];
            // Db::table('SHOP_CART')
            // ->where($where)
            // ->update($update);
            return 1;exit();
        }

	$data['CURRICULUMID']=$Request['id'];
    	$data['USERID']=$_SESSION['userid'];
    	$data['DATETIME']=date('Y-m-d H:i:s');
    	$data['ID']=uniqid();
    	$data['NUM']=$Request['num'];
    	$data['COUNPONID']=$Request['couponid'];
        $data['PRICE']=$Request['price'];
    	Db::table('SHOP_CART')->insert($data);
    	@$_SESSION['cartnum']++;
    	return 1;
    }
    //删除购物车
    function del_cart(){
    	$Request=request()->post();
    	Db::table('SHOP_CART')->where('ID',$Request['id'])->delete();
    	return 1;
    }
   
}
