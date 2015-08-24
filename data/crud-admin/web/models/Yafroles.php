<?php

/**
 *      [CodeJm!] Author CodeJm[codejm@163.com].
 *
 *      角色
 *      $Id: Yafroles.php 2015-08-21 10:31:24 codejm $
 */

class YafrolesModel extends \Core_CModel {

    public $_table = '`yaf_roles`';

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID', 
            'name' => '角色名称', 
            'dateline' => '添加时间', 
            'status' => '状态',
        );
    }

    /**
     * 验证规则
     *
     */
    public function rules() {
        return array(
            'default'=> array(
                array('name', 'required|maxlength[100]'),
                array('dateline', 'maxlength[10]|integer'),
                array('status', 'maxlength[1]|integer'),

            ),
        );
    }

    /**
     * 批量删除
     *
     */
    public function delYafroless($ids) {
        $ids_str = implode(',', array_fill(0, count($ids), '?'));
        $where = 'id IN ('.$ids_str.')';
        return $this->update($where, array('status'=>-1), $ids);
    }
}

?>
