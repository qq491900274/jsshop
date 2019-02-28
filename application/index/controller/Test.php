<?php
namespace app\index\controller;
use think\Controller;
use think\View;
use think\Request;
use think\Session;

use \think\Db;


class Text extends Controller
{	
	public function __construct(){
		parent::__construct();
	}
	
    public function text(){
    	return $this->fetch('text'); 
    }
}
