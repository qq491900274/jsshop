<?php 
namespace app\admin\model;

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

    public function dele($table,$where=''){
        if (!empty($where)) {
            $where=" where ".$where;
        }

        $sql="delete from {$table} {$where}";
        
     return Db::query($sql);
    }

}