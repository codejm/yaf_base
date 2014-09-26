<?php

/**
 *      [CodeJm!] Author CodeJm[codejm@163.com].
 *
 *      用户表
 *      $Id: Members.php 2014-09-26 14:54:06 codejm $
 */

class MembersModel extends \Core_CMode {

    public $_table = '`yaf_members`';

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'uid' => 'UID', 
            'username' => '用户名', 
            'password' => '密码', 
            'gender' => '性别', 
            'face' => '头像', 
            'aboutme' => '关于我', 
            'regip' => '注册ip', 
            'reg_ip_port' => '注册ip端口', 
            'regdate' => '注册时间', 
            'email' => '邮箱', 
            'email_checked' => '邮箱是否验证', 
            'role_type' => '角色', 
            'mobile' => '电话', 
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
                array('username', 'required|maxlength[100]'),
                array('password', 'required|maxlength[100]'),
                array('gender', 'maxlength[1]|integer'),
                array('face', 'maxlength[120]'),
                array('aboutme', 'maxlength[255]'),
                array('regip', 'required|maxlength[15]'),
                array('reg_ip_port', 'required|maxlength[6]'),
                array('regdate', 'required|maxlength[10]|integer'),
                array('email', 'required|maxlength[50]|email'),
                array('email_checked', 'maxlength[1]|integer'),
                array('role_type', 'required|maxlength[10]'),
                array('mobile', 'maxlength[15]|phone'),
                array('status', 'maxlength[1]|integer'),

            ),
        );
    }

    /**
     * 批量删除
     *
     */
    public function delMemberss($ids) {
        $ids_str = implode(',', array_fill(0, count($ids), '?'));
        $where = 'uid IN ('.$ids_str.')';
        return $this->update($where, array('status'=>-1), $ids);
    }
}

?>
