<?php

/**
 *      [CodeJm!] Author CodeJm[codejm@163.com].
 *
 *
 *      $Id: Login.php 2014-07-29 16:37:05 codejm $
 */

class LoginController extends \Core_BaseCtl {

    /**
     * 后台登录显示
     *
     */
    public function indexAction() {
        if($this->getRequest()->isPost()) {

            // test
            $member = new MembersModel();
            $pdata = $this->getAllPost();
            $result = $member->validation->validate($pdata, 'only_login');
            $member->parseAttributes($pdata);
            if($result) {
                $data = $member->select(array('where'=>array('username'=>$member->username, 'status>'=>'1')));
                // 验证是否可以登录
                if($data && $data['password'] == Tools_help::hash($member->password)) {

                    $member->reMemberMe($data, $member->rememberme);
                    $this->redirect(Tools_help::url('backend/index/index'));
                } else {
                    $this->_view->assign("errors", $this->errorStr('用户名或密码错误请重新填写'));
                }
            } else {
                $this->_view->assign("errors", $member->validation->getErrorSummaryFormatted());
            }
            $this->_view->assign("member", $member);
        }
        $this->_view->assign("pageTitle", '后台登录');
    }

    /**
     * 管理员退出
     *
     */
    public function logoutAction() {
        Tools_help::setSession('member', '');
        Tools_help::setCookie('member', '', 0);
        $this->redirect('/backend/login/index');
    }
}

?>
