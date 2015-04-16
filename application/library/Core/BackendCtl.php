<?php

/**
 *      [CodeJm!] Author CodeJm[codejm@163.com].
 *
 *      后台基础Controller父类, 可以进行登录，权限验证
 *      $Id: Backend.php 2014-07-27 20:22:43 codejm $
 */

class Core_BackendCtl extends \Core_BaseCtl {

    public $menuArr = array();

    // 初始化
    public function init() {
        parent::init();


        // ---------------- 判断登录 --------------------------------------
        $admin = '';
        $relogin = false;
        // 判断session
        $admin = Tools_help::getSession('admin');
        if(empty($admin)){
            // 判断cookie
            $admin = Tools_help::getCookie('admin');
            if(empty($admin)){
                $this->redirect('/backend/Login/index');
            } else {
                $relogin = true;
            }
        }

        // cookie重新验证
        if($admin && $relogin) {
            $adminModel = new AdminModel();
            $data = $adminModel->getAdminById($admin['id']);
            if(empty($data)  || $data['roleid'] != 1 || $data['password'] != $admin['password']) {
                $this->redirect('/backend/Login/index');
            }
            $adminModel->reMemberMe($data);
            $admin = $data;
        }

        // E
        $this->_view->assign("curr_admin", $admin);


        // 用户权限判断
        /*$checkTitle = strtolower($this->moduleName.'_'.$this->controllerName.'_'.$this->actionName);
        $pid = Rbac_Core::getPermissions()->returnId($checkTitle);
        if($pid) {
            if($admin['id']!=1){
                if(!Rbac_Core::getInstance()->check($pid, $admin['id'])) {
                    exit('您没有权限访问该网页1！<a href="javascript:window.history.back();">返回</a> ');
                }
            }
        } else {
            Rbac_Core::getPermissions()->add($checkTitle, $checkTitle);
            //exit('您没有权限访问该网页2！<a href="javascript:window.history.back();">返回</a> ');
        }*/

        // 后台菜单数组 S
        $backendMenu = new \Core_CBackendMenu(ConstDefine::$backendMenu, $this->controllerName, $this->actionName, $purview);
        $menustr = $backendMenu->get();
        $this->_view->assign('backendMenu', $menustr);
        // E

    }
}

?>
