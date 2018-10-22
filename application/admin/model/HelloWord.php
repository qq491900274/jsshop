<?php 
namespace app\index\model;

use think\Model;
use \think\Db;
class HelloWord extends Model
{

    function __construct(){
    	 Db::connect('mysql://root:root@127.0.0.1:3306/test#utf8');	
    }
    
    function hello($table){
	 	return Db::query("select * from {$table}");
    }
}