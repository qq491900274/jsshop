<?php
namespace app\admininterface\behavior;
use think\Session;
use think\Request;
use think\Controller;

class OperateBehavior 
{
    /**
     * 权限验证
     * add it by Daniel at 2019/5/18
     */
    public function run(Request $Request)
    {
        return;
    	// 行为逻辑
        // 获取当前访问路由
        $url  = $this->getActionUrl($Request);

        // 用户所拥有的权限路由
        $actions = Session::get('actions')?Session::get('actions'):[];
        if(!$actions||$actions == 2){
            returnAjax('您目前没有权限，请联系超级管理员',2002);
        }
	 $admin = Session::get('admin');
	 $actionsarr = explode("|||",$actions);
        if(!in_array($url, $actionsarr)&&$actions != 1&&$admin !='admin'){
            returnAjax('您无权限访问此接口',2003);
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