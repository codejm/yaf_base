<?php

/**
 *      [CodeJm!] Author CodeJm[codejm@163.com].
 *
 *      管理员表
 *      $Id: Admin.php 2015-08-21 10:31:24 codejm $
 */

class AdminModel extends \Core_CModel {

    public $_table = '`admin`';

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'id', 
            'username' => 'username', 
            'password' => 'password', 
            'nickname' => 'nickname', 
            'realname' => 'realname', 
            'email' => 'email', 
            'is_del' => 'is_del',
        );
    }

    /**
     * 验证规则
     *
     */
    public function rules() {
        return array(
            'default'=> array(
                array('username', 'required|maxlength[32]'),
                array('password', 'required|maxlength[32]'),
                array('nickname', 'required|maxlength[32]'),
                array('realname', 'required|maxlength[16]'),
                array('email', 'required|maxlength[255]|email'),
                array('is_del', 'required|maxlength[0]'),

            ),
        );
    }

    /**
     * 批量删除
     *
     */
    public function delAdmins($ids) {
        $ids_str = implode(',', array_fill(0, count($ids), '?'));
        $where = 'id IN ('.$ids_str.')';
        return $this->update($where, array('status'=>-1), $ids);
    }
}

?>
