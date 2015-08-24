<?php

/**
 *      [CodeJm!] Author CodeJm[codejm@163.com].
 *
 *      
 *      $Id: Wzcxuser.php 2015-08-21 10:31:24 codejm $
 */

class WzcxuserModel extends \Core_CModel {

    public $_table = '`wzcx_user`';

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'num' => '车牌号', 
            'evin' => '识别代号', 
            'ecarType' => '车辆类型', 
            'dateline' => '最后查询日期', 
            'mobile' => '手机号', 
            'code' => '验证码', 
            'mobiledate' => '定制时间', 
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
                array('evin', 'maxlength[10]'),
                array('ecarType', 'maxlength[10]'),
                array('dateline', 'maxlength[10]|integer'),
                array('mobile', 'maxlength[11]|phone'),
                array('code', 'maxlength[10]'),
                array('mobiledate', 'maxlength[10]|integer'),
                array('status', 'maxlength[3]|integer'),

            ),
        );
    }

    /**
     * 批量删除
     *
     */
    public function delWzcxusers($ids) {
        $ids_str = implode(',', array_fill(0, count($ids), '?'));
        $where = 'num IN ('.$ids_str.')';
        return $this->update($where, array('status'=>-1), $ids);
    }
}

?>
