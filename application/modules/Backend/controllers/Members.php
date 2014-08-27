<?php

/**
 *      [CodeJm!] Author CodeJm[codejm@163.com].
 *
 *      用户表 管理类
 *      $Id: Members.php 2014-08-22 17:52:14 codejm $
 */

class MembersController extends \Core_BackendCtl {

    /**
     * 用户表列表
     *
     */
    public function indexAction() {
        // 分页
        $page = intval($this->getg('page', 1));
        $pageSize = 10;
        // 排序
        $orderby = $this->getg('sort');
        if($orderby) {
            $orderby = str_replace('.', ' ', $orderby);
        } else {
            $orderby = 'uid asc';
        }

        // 实例化Model
        $members = new MembersModel();
        // 查询条件
        $params = array(
            'field' => array(),
            'where' => array('status>'=>0),
            'order' => $orderby,
            'page' => $page,
            'per' => $pageSize,
        );
        // 列表
        $result = $members->getList($params);
        // 数据总条数
        $total = $members->getCount($params);

        // 分页url
        $url = Tools_help::url('backend/members/index').'?page=';
        $pagestr = Tools_help::pager($page, $total, $pageSize, $url);

        // 模版分配数据
        $this->_view->assign('pagestr', $pagestr);
        $this->_view->assign('result', $result);
        $this->_view->assign("pageTitle", '用户表列表');
    }

    /**
     * 添加用户表
     *
     */
    public function addAction() {
        // 实例化Model
        $members = new MembersModel();
        // 处理post数据
        if($this->getRequest()->isPost()) {
            // 获取所有post数据
            $pdata = $this->getAllPost();
            // 处理图片等特殊数据
            $imageInfo = Tools_help::upload('face', 'members');
            if(!empty($imageInfo)) {
                $pdata['face'] = $imageInfo;
            } else {
                unset($pdata['face']);
            }

            // 验证
            $result = $members->validation->validate($pdata, 'add');
            $members->parseAttributes($pdata);

            // 用户名验证
            $data = $members->select(array('where'=>array('username'=>$members->username)));
            if($data) {
                $result = false;
                $members->errors['username'][] = '用户名 已经存在，请重新填写!';
            }

            // 通过验证
            if($result) {
                // 入库前数据处理
                $members->regdate = Tools_help::htime($members->regdate);
                $members->password = Tools_help::hash($members->password);

                // Model转换成数组
                $data = $members->toArray($pdata);
                $result = $members->insert($data);
                if($result) {
                    // 提示信息并跳转到列表
                    Tools_help::setSession('Message', '添加成功！');
                    $this->redirect('/backend/members/index');
                } else {
                    // 验证失败
                    $this->_view->assign('ErrorMessage', '添加失败！');
                    $this->_view->assign("errors", $members->validation->getErrorSummary());
                }
            } else {
                // 验证失败
                $this->_view->assign('ErrorMessage', '添加失败！');
                $this->_view->assign("errors", $members->validation->getErrorSummary());
            }
        }

        // 格式化表单数据
        $members->regdate = Tools_help::hdate();
        $members->regip = Tools_help::getIp();
        $members->reg_ip_port = Tools_help::getIpPort();
        $members->role_type = 'admin';

        // 模版分配数据
        $this->_view->assign("members", $members);
        $this->_view->assign("pageTitle", '添加用户表');
    }

    /**
     * 编辑用户表
     *
     */
    public function editAction() {
        // 获取主键
        $uid = $this->getg('uid', 0);
        if(empty($uid)) {
            $this->error('uid 不能为空!');
        }

        // 实例化Model
        $members = new MembersModel();

        // 处理Post
        if($this->getRequest()->isPost()) {
            // 获取所有post数据
            $pdata = $this->getAllPost();
            // 处理图片等特殊数据
            $imageInfo = Tools_help::upload('face', 'members');
            if(!empty($imageInfo)) {
                $pdata['face'] = $imageInfo;
            } else {
                unset($pdata['face']);
            }

            // 验证
            $result = $members->validation->validate($pdata, 'edit');
            $members->parseAttributes($pdata);

            // 用户名验证
            $data = $members->select(array('where'=>array('username'=>$members->username)));
            if($data && $data['uid'] != $uid) {
                $result = false;
                $members->errors['username'][] = '用户名 已经存在，请重新填写!';
            }

            // 通过验证
            if($result) {

                // 入库前数据处理
                $pdata['regdate'] = Tools_help::htime($members->regdate);
                // 密码
                if(isset($pdata['password']) && !empty($pdata['password'])){
                    $pdata['password'] = Tools_help::hash($pdata['password']);
                } else {
                    unset($pdata['password']);
                }

                // Model转换成数组
                $data = $members->toArray($pdata);
                $result = $members->update(array('uid'=>$uid), $data);

                if($result) {
                    // 提示信息并跳转到列表
                    Tools_help::setSession('Message', '修改成功！');
                    $this->redirect('/backend/members/index');
                } else {
                    // 出错
                    Tools_help::setSession('ErrorMessage', '修改失败, 请确定已修改了某项！');
                    $this->_view->assign("errors", $members->validation->getErrorSummary());
                }
            } else {
                // 验证失败
                Tools_help::setSession('ErrorMessage', '修改失败, 请检查错误项');
                $this->_view->assign("errors", $members->validation->getErrorSummary());
            }
        }

        // 如果Model数据为空，则获取
        if(!empty($uid) && empty($members->uid)) {
            $data = $members->select(array('where'=>array('uid'=>$uid)));
            $members->parseAttributes($data, 0);
        }

        // 格式化表单数据
        $members->regdate = Tools_help::hdate('Y-m-d H:i:s', $members->regdate);

        // 图片处理
        if($members->face){
            $members->face = Tools_help::fbu($members->face);
        }

        // 模版分配数据
        $this->_view->assign("members", $members);
        $this->_view->assign("pageTitle", '修改用户表');
    }

    /**
     * 单个用户表删除
     *
     */
    public function delAction() {
        $uid = $this->getg('uid', 0);
        if(empty($uid)) {
            $this->error('uid 不能为空!');
        }
        // 实例化Model
        $members = new MembersModel();
        $row = $members->update(array('uid'=>$uid), array('status'=>-1));
        if($row) {
            $this->error('恭喜，删除成功', 'Message');
        } else {
            $this->error('删除失败');
        }
    }

    /**
     * 批量删除用户表或者调整顺序
     *
     */
    public function batchAction() {
        $uids = $this->getp('dels');
        if(empty($uids)) {
            $this->error('uid 不能为空!');
        }
        // 实例化Model
        $members = new MembersModel();
        $row = $members->delMemberss($uids);
        if($row) {
            $this->error('恭喜，删除成功', 'Message');
        } else {
            $this->error('删除失败');
        }
    }

    /**
     * 修改用户表状态
     *
     *
     */
    public function statusAction() {
        $uid = $this->getg('uid', 0);
        if(empty($uid)) {
            $this->error('uid 不能为空!');
        }
        $status = $this->getg('status', 0);
        $status = $status ? 0 : 1;
        // 实例化Model
        $members = new MembersModel();
        $row = $members->update(array('uid'=>$uid), array('status'=>$status));
        if($row) {
            $this->error('恭喜，操作成功', 'Message');
        } else {
            $this->error('操作失败');
        }

    }

}

?>
