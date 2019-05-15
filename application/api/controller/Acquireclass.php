<?php
namespace app\api\controller;
use think\ControllerAPI;
use think\View;
use think\Request;
use think\Session;



class Acquireclass extends ControllerAPI
{	
	public function __construct(){
		parent::__construct();
	}
		
    public function index(){
      $url='10.10.18.191:8080/stuapp_web/anonymity/webDeanClass/webDeanClassList';
      $data['isSelect']='no';
      $data['pageNumber']='1';
      $data['pageSize']='20';
      $val=parent::curl_post($url,$data);
      print($val);
    }
    
}
