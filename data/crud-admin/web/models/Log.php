<?php

/**
 *      [CodeJm!] Author CodeJm[codejm@163.com].
 *
 *      
 *      $Id: Log.php 2014-09-25 17:46:31 codejm $
 */

class LogModel extends \Core_CMode {

    public $_table = '`log`';

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'id', 
            'sid' => 'sid', 
            'nickname' => 'nickname', 
            'qq' => 'qq', 
            'face' => 'face', 
            'area' => 'area', 
            'ip' => 'ip', 
            'keywords' => 'keywords', 
            'page' => 'page', 
            'pagetitle' => 'pagetitle', 
            'referer' => 'referer', 
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
                array('sid', 'required|maxlength[10]|integer'),
                array('nickname', 'maxlength[100]'),
                array('qq', 'required|maxlength[11]|integer'),
                array('face', 'maxlength[255]'),
                array('area', 'maxlength[255]'),
                array('ip', 'maxlength[20]'),
                array('keywords', 'maxlength[255]'),
                array('page', 'maxlength[255]'),
                array('pagetitle', 'maxlength[255]'),
                array('referer', 'maxlength[255]'),
                array('createtime', 'required|maxlength[10]|integer'),

            ),
        );
    }

    /**
     * 批量删除
     *
     */
    public function delLogs($ids) {
        $ids_str = implode(',', array_fill(0, count($ids), '?'));
        $where = 'id IN ('.$ids_str.')';
        return $this->update($where, array('status'=>-1), $ids);
    }
}

?>
