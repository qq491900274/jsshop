<?php
namespace app\index\controller;
use think\mobile_controller;
use think\Controller;
use think\View;
use think\Request;
use think\Session;
use app\index\lib\Home;//deng xia


class Test extends mobile_controller
{ 
    public function index(){
      //$this->assign('name','ThinkPHP');
       return $this->fetch('index'); 
    }
    public function test()
    {
     return $this->fetch('test');
    }
    public function testResult()
    {
     return $this->fetch('testResult');
    }
    public function testResult_1()
    {
     return $this->fetch('testResult_1');
    }
    public function testResult_2()
    {
     return $this->fetch('testResult_2');
    }
    public function testResult_3()
    {
     return $this->fetch('testResult_3');
    }
    public function testResult_4()
    {
     return $this->fetch('testResult_4');
    }
    public function testResult_5()
    {
     return $this->fetch('testResult_5');
    }
    //时间管理
    public function test_time()
    {
     return $this->fetch('test_time');
    }
    public function timeResult()
    {
     return $this->fetch('timeResult');
    }
    //学习动机
    public function test_study()
    {
     return $this->fetch('test_study');
    }
    public function studyResult()
    {
     return $this->fetch('studyResult');
    }
/*简版测试题*/
    //人格问卷
    public function test_two()
    {
     return $this->fetch('test_two');
    }
    public function test_show()
    {
     return $this->fetch('test_show');
    }
    public function time_two()
    {
     return $this->fetch('time_two');
    }
    public function time_show()
    {
     return $this->fetch('time_show');
    }
    public function study_two()
    {
     return $this->fetch('study_two');
    }
    public function study_show()
    {
     return $this->fetch('study_show');
    }
    
    public function test_full()
    {
     return $this->fetch('test_full');
    }
    public function test_sim()
    {
     return $this->fetch('test_sim');
    }
}
