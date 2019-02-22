<?php 
namespace app\index\model;
use app\index\lib\CLogFileHandler;
use app\index\lib\Log;
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
    
    public function update_all($table,$set,$where){
    	if (!empty($where)) {
            $where=" where ".$where;
        }
        $sql="update {$table} set {$set} {$where}";
    
     	 return Db::query($sql);
    }
}