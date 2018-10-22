<?php
namespace app\index\lib;
use think\Controller;
use think\View;
use think\Request;
use think\Session;


class Home extends Controller
{	
    public function __construct(){
    	parent::__construct();
    }
   
    public function hell(){
    	$name = 'helloword1';
    	$this->assign('name',$name);
    }
}
