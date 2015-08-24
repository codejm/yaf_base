<?php

/**
 *      [CodeJm!] Author CodeJm[codejm@163.com].
 *
 *      用户角色管理
 *      $Id: Roles.php 2015-08-21 14:26:51 codejm $
 */

class RolesController extends \Core_BackendCtl {

    // 用户角色列表
    public function indexAction() {
        $rbac = new Rbac_Core();
        $result = $rbac->getRoles();
        // 模版分配数据
        $this->_view->assign('result', $result);
        $this->_view->assign("pageTitle", '角色列表');
    }

    // 赋值权限
    public function editPermissionAction() {
        $id = $this->getg('id', 0);
        if(empty($id))
            exit();

        $rbac = new Rbac_Core();
        if($this->getRequest()->isPost()){
            $rp = $this->getp("rp");
            $rbac->assign($id, $rp, time());
            Tools_help::setSession('Message', '修改成功！');
            $this->redirect(Tools_help::url('/backend/roles/editPermission', array('id'=>$id)));
            exit();
        }

        $rp = $rbac->getRolePermissions($id);
        $rpArr = array();
        foreach ($rp as $value) {
            $rpArr[$value['pid']] = $value['pid'];
        }
        unset($rp);
        $permissions = $rbac->getPermissions();
        $permissionArr = array();
        if($permissions){
            foreach ($permissions as $item) {
                if($item['ismenu'] == -1){
                    $permissionArr[$item['id']] = $item;
                } else {
                    $permissionArr[$item['fid']]['sub'][] = $item;
                }
            }
        }
        $this->_view->assign('result', $permissionArr);
        $this->_view->assign('rpArr', $rpArr);
        $this->_view->assign('id', $id);
        $this->_view->assign("pageTitle", '赋权限');
    }

    /**
     * 添加角色
     *
     */
    public function addAction() {
        // 实例化Model
        $rbac = new Rbac_Core();
        $name = $this->getp('name');
        // 处理post数据
        if($this->getRequest()->isPost()) {
            $result = true;
            $errors = array();
            if(empty($name)){
                $result = false;
                $errors['name'] = '角色名称不能为空！';
            } else {
                $data = $rbac->getRole($name);
                if($data) {
                    $result = false;
                    $errors['name'] = '角色名称已经存在！';
                }
            }
            // 通过验证
            if($result) {
                $result = $rbac->addRole($name, time());
                if($result) {
                    // 提示信息并跳转到列表
                    Tools_help::setSession('Message', '添加成功！');
                    $this->redirect('/backend/roles/index');
                } else {
                    // 验证失败
                    $this->_view->assign('ErrorMessage', '添加失败！');
                }
            } else {
                // 验证失败
                $this->_view->assign('ErrorMessage', '添加失败！');
                $this->_view->assign("errors", $errors);
            }
        }

        // 模版分配数据
        $this->_view->assign("name", $name);
        $this->_view->assign("pageTitle", '添加角色');
    }

    /**
     * 编辑角色
     *
     */
    public function editAction() {
        // 获取主键
        $id = $this->getg('id', 0);
        if(empty($id)) {
            $this->error('id 不能为空!');
        }

        // 实例化Model
        $rbac = new Rbac_Core();
        // 处理Post
        if($this->getRequest()->isPost()) {
            $name = $this->getp('name');
            $result = true;
            $errors = array();
            if(empty($name)){
                $result = false;
                $errors['name'] = '角色名称不能为空！';
            } else {
                $data = $rbac->getRole($name);
                if($data && $data['id']!=$id) {
                    $result = false;
                    $errors['name'] = '角色名称已经存在！';
                }
            }
            // 通过验证
            if($result) {
                $result = $rbac->editRole($id, $name);
                if($result) {
                    // 提示信息并跳转到列表
                    Tools_help::setSession('Message', '修改成功！');
                    $this->redirect('/backend/roles/index');
                } else {
                    // 验证失败
                    $this->_view->assign('ErrorMessage', '修改失败！');
                }
            } else {
                // 验证失败
                $this->_view->assign('ErrorMessage', '修改失败！');
                $this->_view->assign("errors", $errors);
            }
        }
        if(empty($name)){
            $data = $rbac->getRole($id);
            if($data)
                $name = $data['name'];
            else{
                // 提示信息并跳转到列表
                Tools_help::setSession('ErrorMessage', '没找到对应角色！');
                $this->redirect('/backend/roles/index');
            }
        }

        $this->_view->assign("name", $name);
        $this->_view->assign("id", $id);
        $this->_view->assign("pageTitle", '修改角色');
    }

    /**
     * 单个角色删除
     *
     */
    public function delAction() {
        $id = $this->getg('id', 0);
        if(empty($id)) {
            $this->error('id 不能为空!');
        }
        // 实例化Model
        $rbac = new Rbac_Core();
        $row = $rbac->delRole($id);
        if($row) {
            $this->error('恭喜，删除成功', 'Message');
        } else {
            $this->error('删除失败');
        }
    }

}

?>
