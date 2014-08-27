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
        $member = '';
        $relogin = false;
        // 判断session
        $member = Tools_help::getSession('member');
        if(empty($member)){
            // 判断cookie
            $member = Tools_help::getCookie('member');
            if(empty($member) || $member['role_type'] !== 'admin'){
                $this->redirect('/backend/Login/index');
            } else {
                $relogin = true;
            }
        }

        // cookie重新验证
        if($member && $relogin) {
            $m = new MemberModel();
            $data = $m->getMemberByName($member['username']);
            if(empty($data)  || $data['role_type'] !== 'admin' ||  $data['password'] !== $member['password']) {
                $this->redirect('/backend/Login/index');
            }
            $m->reMemberMe($data);
            $member = $data;
        }

        // E
        $this->_view->assign("member", $member);

        // 后台菜单数组 S
        $backendMenu = new \Core_CBackendMenu(ConstDefine::$backendMenu, $this->controllerName, $this->actionName);
        $menustr = $backendMenu->get();
        $this->_view->assign('backendMenu', $menustr);
        // E

    }
}

?>
