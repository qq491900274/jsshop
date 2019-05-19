<?php
namespace app\admin\controller;
use think\Controller;
use think\View;
use think\Request;
use think\Session;

use \think\Db;

class PcConfig extends Controller
{ 
  public function __construct(){
    parent::__construct();

  }
  
    public function index(){
      return $this->fetch('index');
    }
    public function headerpage(){
      return $this->fetch('headerpage');
    }
    public function indexclass(){
      return $this->fetch('indexclass');
    }
}
 