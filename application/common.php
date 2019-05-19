<?php
//接口返回json格式数据
//add it by Daniel at 2019/5/18
function returnAjax($str,$status=1,$msg="成功"){
        if(is_array($str)){
            $data=array(
                "data"=>$str,
                "msg"=>$msg,
                "status"=>$status
            );
        }else{
            if(empty($str)){
                $data=array(
                    "data"=>null,
                    "msg"=>"失败",
                    "status"=>$status
                );
            }else{
                $data=array(
                    "data"=>null,
                    "msg"=>$str,
                    "status"=>$status
                );
            }
        }
        echo json_encode($data,JSON_UNESCAPED_UNICODE);
        die;
}
//获取唯一id，绝对不可能重复
//add it by Daniel at 2019/5/18
function get_uniqid(){
	return md5(uniqid(md5(microtime(true)),true));
}
//redis默认30天
//add it by Daniel at 2019/5/18
function setCache($key,$val,$expire=2592000) {
	$redis = new Redis();
	$redis->connect('127.0.0.1', 6379);
	//var_dump($key);var_dump($val);die;
	$redis->setex($key,$expire,$val);
	
	
}
//获取缓存
//add it by Daniel at 2019/5/18
function getCache($key) {
	$redis = new Redis();
	$redis->connect('127.0.0.1', 6379);
	$result=$redis->get($key);
	return $result ? $result:false;
	
}

//redis的rpush
//add it by Daniel at 2019/5/18
function redis_rpush($key,$value){
	$redis = new Redis();
	$redis->connect('127.0.0.1', 6379);
	$redis->rpush($key,$value);
}
//redis的lpop
//add it by Daniel at 2019/5/18
function redis_lpop($key){
	$redis = new Redis();
	$redis->connect('127.0.0.1', 6379);
	$value = $redis->lpop($key);
	return $value;
}
//redis的模糊查询
//add it by Daniel at 2019/5/18
function redis_like($key){
	$redis = new Redis();
	$redis->connect('127.0.0.1', 6379);
	$result=$redis->keys($key);
	return $result ? $result:false;
	
}
//redis删除key
//add it by Daniel at 2019/5/18
function redis_delete($key){
	$redis = new Redis();
	$redis->connect('127.0.0.1', 6379);
	$result=$redis->delete($key);
	return $result;
}
//redis验证键
//add it by Daniel at 2019/5/18
function redis_exists($key){
	$redis = new Redis();
	$redis->connect('127.0.0.1', 6379);
	$result=$redis->exists($key);
	return $result;
}