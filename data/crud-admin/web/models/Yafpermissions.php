<?php

/**
 *      [CodeJm!] Author CodeJm[codejm@163.com].
 *
 *      权限
 *      $Id: Yafpermissions.php 2015-08-21 10:31:24 codejm $
 */

class YafpermissionsModel extends \Core_CModel {

    public $_table = '`yaf_permissions`';

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID', 
            'fid' => '父ID', 
            'name' => '权限名称', 
            'path' => '验证路径', 
            'ismenu' => '是否在菜单显示',
        );
    }

    /**
     * 验证规则
     *
     */
    public function rules() {
        return array(
            'default'=> array(
                array('fid', 'required|maxlength[8]|integer'),
                array('name', 'required|maxlength[100]'),
                array('path', 'required|maxlength[64]'),
                array('ismenu', 'maxlength[1]|integer'),

            ),
        );
    }

    /**
     * 批量删除
     *
     */
    public function delYafpermissionss($ids) {
        $ids_str = implode(',', array_fill(0, count($ids), '?'));
        $where = 'id IN ('.$ids_str.')';
        return $this->update($where, array('status'=>-1), $ids);
    }
}

?>
