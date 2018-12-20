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

		if (empty($Request['list']) ) {
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


   
}
