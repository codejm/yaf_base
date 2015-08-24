<?php

/**
 *      [CodeJm!] Author CodeJm[codejm@163.com].
 *
 *      
 *      $Id: Wzcxlogs.php 2015-08-21 10:31:24 codejm $
 */

class WzcxlogsModel extends \Core_CModel {

    public $_table = '`wzcx_logs`';

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'id', 
            'num' => '车牌', 
            'ip' => 'ip', 
            'from' => '查询来源', 
            'referer' => '来源地址', 
            'dateline' => '查询时间', 
            'status' => 'status',
        );
    }

    /**
     * 验证规则
     *
     */
    public function rules() {
        return array(
            'default'=> array(
                array('num', 'required|maxlength[10]'),
                array('ip', 'maxlength[20]'),
                array('from', 'maxlength[30]'),
                array('referer', 'maxlength[255]'),
                array('dateline', 'maxlength[10]|integer'),
                array('status', 'maxlength[3]|integer'),

            ),
        );
    }

    /**
     * 批量删除
     *
     */
    public function delWzcxlogss($ids) {
        $ids_str = implode(',', array_fill(0, count($ids), '?'));
        $where = 'id IN ('.$ids_str.')';
        return $this->update($where, array('status'=>-1), $ids);
    }
}

?>
