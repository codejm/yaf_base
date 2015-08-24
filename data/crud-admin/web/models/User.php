<?php

/**
 *      [CodeJm!] Author CodeJm[codejm@163.com].
 *
 *      
 *      $Id: User.php 2015-08-21 10:31:24 codejm $
 */

class UserModel extends \Core_CModel {

    public $_table = '`user`';

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'id', 
            'username' => 'username', 
            'password' => 'password', 
            'isadmin' => 'isadmin', 
            'regip' => 'regip', 
            'regtime' => 'regtime', 
            'lastip' => 'lastip', 
            'lasttime' => 'lasttime',
        );
    }

    /**
     * 验证规则
     *
     */
    public function rules() {
        return array(
            'default'=> array(
                array('username', 'required|maxlength[50]'),
                array('password', 'required|maxlength[100]'),
                array('isadmin', 'maxlength[3]|integer'),
                array('regip', 'maxlength[20]'),
                array('lastip', 'maxlength[20]'),

            ),
        );
    }

    /**
     * 批量删除
     *
     */
    public function delUsers($ids) {
        $ids_str = implode(',', array_fill(0, count($ids), '?'));
        $where = 'id IN ('.$ids_str.')';
        return $this->update($where, array('status'=>-1), $ids);
    }
}

?>
