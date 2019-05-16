<?php
namespace app\pc\controller;
use think\pc_controller;
use think\View;
use think\Request;
use think\Session;



class Index extends  pc_controller
{	
	public function __construct(){
		parent::__construct();
		
	}
		 
    public function index(){
    	
      return $this->fetch('index'); 
    }
    
  
}
