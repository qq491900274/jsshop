<?php
namespace app\behavior;
use think\Session;
use think\Request;
use think\Controller;

class OperateBehavior extends Controller
{
    /**
     * 权限验证
     * add it by Daniel at 2019/5/18
     */
    public function run(Request $Request)
    {
    	// 行为逻辑
        // 获取当前访问路由
        $url  = $this->getActionUrl($Request);

        if(empty(Session::get())){
            $this->error('请先登录','/admin/login/index');
        }
	 
        // 用户所拥有的权限路由
        $auth = Session::get('authurl')?Session::get('authurl'):[];
        if(!$auth){
            $this->error('您还不是管理员');
        }
	 $admin = Session::get('admin');
        if(!in_array($url, $auth)&&$admin != 1){
            $this->error('您无权限访问此接口');
        }
    }

    /**
     * 获取当前访问路由
     * add it by Daniel at 2019/5/18
     */
    private function getActionUrl($Request)
    {
        $module     = $Request->module();
        $controller = $Request->controller();
        $action     = $Request->action();
        $url        = $module.'/'.$controller.'/'.$action;
        return strtolower($url);
    }
}