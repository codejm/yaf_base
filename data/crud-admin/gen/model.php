<?php

/**
 *      [CodeJm!] Author CodeJm[codejm@163.com].
 *
 *      __TABLENAMEREMARK__
 *      $Id: __TABLENAME__.php __FILETIME__ codejm $
 */

class __TABLENAME__Model extends \Core_CMode {

    public $_table = '`__TNAME__`';

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
__TABLECOLUMNS_ARRAY__
		);
	}

    /**
     * 验证规则
     *
     */
    public function rules() {
        return array(
            'default'=> array(
__TABLECOLUMNS_RULES_ARRAY__
            ),
        );
    }

    /**
     * 批量删除
     *
     */
    public function del__TABLENAME__s($ids) {
        $ids_str = implode(',', array_fill(0, count($ids), '?'));
        $where = '__TABLE_PRIMARYKEY__ IN ('.$ids_str.')';
        return $this->update($where, array('status'=>-1), $ids);
    }
}

?>
