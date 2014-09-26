<?php

/**
 *      [CodeJm!] Author CodeJm[codejm@163.com].
 *
 *      
 *      $Id: Site.php 2014-09-26 14:54:06 codejm $
 */

class SiteModel extends \Core_CMode {

    public $_table = '`site`';

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'id', 
            'uid' => 'uid', 
            'name' => 'name', 
            'url' => 'url', 
            'createtime' => 'createtime',
        );
    }

    /**
     * 验证规则
     *
     */
    public function rules() {
        return array(
            'default'=> array(
                array('uid', 'required|maxlength[10]|integer'),
                array('name', 'required|maxlength[100]'),
                array('url', 'maxlength[120]'),

            ),
        );
    }

    /**
     * 批量删除
     *
     */
    public function delSites($ids) {
        $ids_str = implode(',', array_fill(0, count($ids), '?'));
        $where = 'id IN ('.$ids_str.')';
        return $this->update($where, array('status'=>-1), $ids);
    }
}

?>
