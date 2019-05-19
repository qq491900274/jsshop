<?php 
namespace app\admininterface\model;

use think\Model;
use \think\Db;
class PublicModel extends Model
{

    public function __construct(){
    	
    }
    
    public function select($table,$key,$where=''){
    	if (!empty($where)) {
    		$where=" where ".$where;
    	}

    	$sql="select {$key} from {$table} {$where}";
    	
	    return Db::query($sql);
    }

    public function dele($table,$data){
       return db($table)->where($data)->delete();
    }
    //增加一条数据
    //add it by Daniel at 2019/5/18
    public function add($table,$data){
    	return db($table)->insert($data);
    }
   //增加多条数据
   //add it by Daniel at 2019/5/18
   public function addall($table,$data){
   	return db($table)->insertAll($data);   
   }
}