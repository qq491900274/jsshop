<?php 
namespace app\admininterface\model;

use think\Model;
use \think\Db;
class PublicModel extends Model
{

    public function __construct(){
    	
    }
    
    public function select($table,$key,$where=[],$sort="",$page=1,$pagesize=10){
    	$start = ($page-1)*$pagesize;
	return db($table)->field($key)->where($where)->order($sort)->limit($start,$pagesize)->select();

    }
    public function getone($table,$key,$where=[]){
      $val=db($table)->field($key)->where($where)->find();
      //echo db($table)->getLastSql();
    	return $val;

    }

    public function getselect($table,$key,$where=[]){
      $val=db($table)->field($key)->where($where)->select();
      //echo db($table)->getLastSql();
      return $val;

    }
    //删除数据
    public function dele($table,$where){
       return db($table)->where($where)->delete();
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
   //更新数据
   //add it by Daniel at 2019/5/19
   public function upd($table,$where,$data){
       return db($table)->where($where)->update($data);
    }
    //更新数据（原有的字符串增加）
    //add it by Daniel at 2019/5/19
    public function upd_concat($table,$key,$str,$where){
    	if (!empty($where)) {
    		$where=" where ".$where;
    	}
    	$sql="update {$table} set {$key}=CONCAT({$key},'{$str}') {$where}";
	return Db::query($sql);
    }
    //查询总页码
    //add it by Daniel at 2019/5/19
    public function pcount($table,$where=[],$pagesize){
    	return ceil($this->count($table,$where)/$pagesize);
    }
    //查询总条数
    //add it by Daniel at 2019/5/20
    public function count($table,$where=[]){
    	return db($table)->where($where)->count();
    }
}


