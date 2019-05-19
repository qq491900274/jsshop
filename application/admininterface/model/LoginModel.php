<?php 
namespace app\admin\model;

use think\Model;
use \think\Db;
class LoginModel extends Model
{

    function __construct(){
    	 //Db::connect('mysql://root:root@127.0.0.1:3306/test#utf8');	
    }
    
    function select($table,$key,$where){
    	if (!empty($where)) {
    		$where=" where ".$where;
    	}

    	$sql="select {$key} from {$table} {$where}";
    	//echo $sql;
	 return Db::query($sql);
    }
}