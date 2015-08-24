<?php

/**
 *      [CodeJm!] Author CodeJm[codejm@163.com].
 *
 *      
 *      $Id: Menu.php 2015-08-21 10:31:24 codejm $
 */

class MenuModel extends \Core_CModel {

    public $_table = '`menu`';

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'id', 
            'pid' => 'pid', 
            'name' => 'name', 
            'display' => 'display', 
            'target' => 'target', 
            'sort' => 'sort', 
            'url' => 'url',
        );
    }

    /**
     * 验证规则
     *
     */
    public function rules() {
        return array(
            'default'=> array(
                array('pid', 'required|maxlength[8]|integer'),
                array('name', 'required|maxlength[64]'),
                array('display', 'required|maxlength[0]'),
                array('target', 'required|maxlength[10]'),
                array('sort', 'maxlength[3]|integer'),
                array('url', 'required|maxlength[255]'),

            ),
        );
    }

    /**
     * 批量删除
     *
     */
    public function delMenus($ids) {
        $ids_str = implode(',', array_fill(0, count($ids), '?'));
        $where = 'id IN ('.$ids_str.')';
        return $this->update($where, array('status'=>-1), $ids);
    }
}

?>
