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

    //返回符合条件的课程
    function get_class(){
    	$Request=request()->post();
		$this->pmodel =  new \app\index\model\PublicModel(); 
		$where='';

		if (!empty($Request['school'])) {
			$where=" SCHOOLID='{$Request['school']}'";
		}else{
			return json_encode(array('msg'=>'缺少校区参数！','state'=>'2'));
		}

		if (!empty($Request['class'])) {
			$where.=" and CLASSGUID='{$Request['school']}'";
		}else{
			return json_encode(array('msg'=>'缺少年级参数！','state'=>'2'));
		}

		if (!empty($Request['subject'])) {
			$where.=" and SUBJECTGUID='{$Request['subject']}'";
		}else{
			return json_encode(array('msg'=>'缺少科目参数！','state'=>'2'));
		}

		if (!empty($Request['classtypeguid'])) {
			$where.=" and CLASSTYPEGUID='{$Request['classtypeguid']}'";
		}else{
			return json_encode(array('msg'=>'缺少科目参数！','state'=>'2'));
		}
		
		$key='ID,NAME,CODE,PRICE,DATETIME,CONTENT,SEASONTYPE,STARTTIME,ENDTIME,COURSENUM,COURSETIME,IMG,COUNT';
		$data=$this->pmodel->select('SHOP_CURRICULUM',$key,$where);
		return $data;
    }

    //返回课堂类型
    function get_classtype(){
    	$key='ID,NAME';
		$data=$this->pmodel->select('SHOP_CURRICULUM_TYPE',$key,$where);
		return $data;
    }
   
}
