<?php

/**
 *      [CodeJm!] Author CodeJm[codejm@163.com].
 *
 *      新闻
 *      $Id: News.php 2014-09-26 14:54:06 codejm $
 */

class NewsModel extends \Core_CMode {

    public $_table = '`yaf_news`';

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID', 
            'title' => '标题', 
            'img' => '头图', 
            'remark' => '描述', 
            'detail' => '详情', 
            'dateline' => '创建时间', 
            'updatetime' => '更新时间', 
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
                array('title', 'required|maxlength[100]'),
                array('img', 'maxlength[120]'),
                array('remark', 'maxlength[500]'),
                array('detail', 'required'),
                array('dateline', 'maxlength[10]|integer'),
                array('updatetime', 'maxlength[10]|integer'),
                array('status', 'maxlength[1]|integer'),

            ),
        );
    }

    /**
     * 批量删除
     *
     */
    public function delNewss($ids) {
        $ids_str = implode(',', array_fill(0, count($ids), '?'));
        $where = 'id IN ('.$ids_str.')';
        return $this->update($where, array('status'=>-1), $ids);
    }
}

?>
