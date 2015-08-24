<?php

/**
 *      [CodeJm!] Author CodeJm[codejm@163.com].
 *
 *      用户表
 *      $Id: Yafmembers.php 2015-08-21 10:31:24 codejm $
 */

class YafmembersModel extends \Core_CModel {

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
            'regipport' => '注册ip端口', 
            'regdate' => '注册时间', 
            'email' => '邮箱', 
            'emailchecked' => '邮箱是否验证', 
            'rid' => '角色', 
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
                array('regipport', 'required|maxlength[6]'),
                array('regdate', 'required|maxlength[10]|integer'),
                array('email', 'required|maxlength[50]|email'),
                array('emailchecked', 'maxlength[1]|integer'),
                array('rid', 'required|maxlength[5]|integer'),
                array('mobile', 'maxlength[15]|phone'),
                array('status', 'maxlength[1]|integer'),

            ),
        );
    }

    /**
     * 批量删除
     *
     */
    public function delYafmemberss($ids) {
        $ids_str = implode(',', array_fill(0, count($ids), '?'));
        $where = 'uid IN ('.$ids_str.')';
        return $this->update($where, array('status'=>-1), $ids);
    }
}

?>
