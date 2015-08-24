<?php

/**
 *      [CodeJm!] Author CodeJm[codejm@163.com].
 *
 *      权限 管理类
 *      $Id: Yafpermissions.php 2015-08-21 10:31:24 codejm $
 */

class YafpermissionsController extends \Core_BackendCtl {

    /**
     * 权限列表
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
            $orderby = 'id desc';
        }

        // 实例化Model
        $yafpermissionsModel = new YafpermissionsModel();
        // 查询条件
        $params = array(
            'field' => array(),
            'where' => array('status>'=>0),
            'order' => $orderby,
            'page' => $page,
            'per' => $pageSize,
        );
        // 列表
        $result = $yafpermissionsModel->getLists($params);
        // 数据总条数
        $total = $yafpermissionsModel->getCount($params);

        // 分页url
        $url = Tools_help::url('backend/yafpermissions/index').'?page=';
        $pagestr = Tools_help::pager($page, $total, $pageSize, $url);

        // 模版分配数据
        $this->_view->assign('pagestr', $pagestr);
        $this->_view->assign('result', $result);
        $this->_view->assign("pageTitle", '权限列表');
    }

    /**
     * 添加权限
     *
     */
    public function addAction() {
        // 实例化Model
        $yafpermissionsModel = new YafpermissionsModel();
        // 处理post数据
        if($this->getRequest()->isPost()) {
            // 获取所有post数据
            $pdata = $this->getAllPost();
            // 处理图片等特殊数据

            // 验证
            $result = $yafpermissionsModel->validation->validate($pdata, 'add');
            $yafpermissionsModel->parseAttributes($pdata);

            // 通过验证
            if($result) {
                // 入库前数据处理

                // Model转换成数组
                $data = $yafpermissionsModel->toArray($pdata);
                $result = $yafpermissionsModel->insert($data);
                if($result) {
                    // 提示信息并跳转到列表
                    Tools_help::setSession('Message', '添加成功！');
                    $this->redirect('/backend/yafpermissions/index');
                } else {
                    // 验证失败
                    $this->_view->assign('ErrorMessage', '添加失败！');
                    $this->_view->assign("errors", $yafpermissionsModel->validation->getErrorSummary());
                }
            } else {
                // 验证失败
                $this->_view->assign('ErrorMessage', '添加失败！');
                $this->_view->assign("errors", $yafpermissionsModel->validation->getErrorSummary());
            }
        }

        // 格式化表单数据


        // 模版分配数据
        $this->_view->assign("yafpermissions", $yafpermissionsModel);
        $this->_view->assign("pageTitle", '添加权限');
    }

    /**
     * 编辑权限
     *
     */
    public function editAction() {
        // 获取主键
        $id = $this->getg('id', 0);
        if(empty($id)) {
            $this->error('id 不能为空!');
        }

        // 实例化Model
        $yafpermissionsModel = new YafpermissionsModel();

        // 处理Post
        if($this->getRequest()->isPost()) {
            // 获取所有post数据
            $pdata = $this->getAllPost();
            // 处理图片等特殊数据

            // 验证
            $result = $yafpermissionsModel->validation->validate($pdata, 'edit');
            $yafpermissionsModel->parseAttributes($pdata);

            // 通过验证
            if($result) {
                // 入库前数据处理


                // Model转换成数组
                $data = $yafpermissionsModel->toArray($pdata);
                $result = $yafpermissionsModel->update(array('id'=>$id), $data);

                if($result) {
                    // 提示信息并跳转到列表
                    Tools_help::setSession('Message', '修改成功！');
                    $this->redirect('/backend/yafpermissions/index');
                } else {
                    // 出错
                    Tools_help::setSession('ErrorMessage', '修改失败, 请确定已修改了某项！');
                    $this->_view->assign("errors", $yafpermissionsModel->validation->getErrorSummary());
                }
            } else {
                // 验证失败
                Tools_help::setSession('ErrorMessage', '修改失败, 请检查错误项');
                $this->_view->assign("errors", $yafpermissionsModel->validation->getErrorSummary());
            }
            $yafpermissionsModel->id = $id;
        }

        // 如果Model数据为空，则获取
        if(!empty($id) && empty($yafpermissionsModel->id)) {
            $data = $yafpermissionsModel->select(array('where'=>array('id'=>$id)));
            $yafpermissionsModel->parseAttributes($data);
        }

        // 格式化表单数据


        // 模版分配数据
        $this->_view->assign("yafpermissions", $yafpermissionsModel);
        $this->_view->assign("pageTitle", '修改权限');
    }

    /**
     * 单个权限删除
     *
     */
    public function delAction() {
        $id = $this->getg('id', 0);
        if(empty($id)) {
            $this->error('id 不能为空!');
        }
        // 实例化Model
        $yafpermissionsModel = new YafpermissionsModel();
        $row = $yafpermissionsModel->update(array('id'=>$id), array('status'=>-1));
        if($row) {
            $this->error('恭喜，删除成功', 'Message');
        } else {
            $this->error('删除失败');
        }
    }

    /**
     * 批量删除权限或者调整顺序
     *
     */
    public function batchAction() {
        $ids = $this->getp('dels');
        if(empty($ids)) {
            $this->error('id 不能为空!');
        }
        // 实例化Model
        $yafpermissionsModel = new YafpermissionsModel();
        $row = $yafpermissionsModel->delYafpermissionss($ids);
        if($row) {
            $this->error('恭喜，删除成功', 'Message');
        } else {
            $this->error('删除失败');
        }
    }

    /**
     * 修改权限状态
     *
     *
     */
    public function statusAction() {
        $id = $this->getg('id', 0);
        if(empty($id)) {
            $this->error('id 不能为空!');
        }
        $status = $this->getg('status', 0);
        $status = $status ? 0 : 1;
        // 实例化Model
        $yafpermissionsModel = new YafpermissionsModel();
        $row = $yafpermissionsModel->update(array('id'=>$id), array('status'=>$status));
        if($row) {
            $this->error('恭喜，操作成功', 'Message');
        } else {
            $this->error('操作失败');
        }

    }

}

?>
