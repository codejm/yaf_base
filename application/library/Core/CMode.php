<?php

/**
 *      [CodeJm!] Author CodeJm[codejm@163.com].
 *
 *
 *      $Id: CModel.php 2014-07-30 09:01:43 codejm $
 */

class Core_CMode {

    /**
     * Simple constructor to grab the database and cache instances
     */
    public function __construct() {
    }

    /**
     * 接纳任何属性
     */
    public function __get($name) {
        if($name == 'db'){
            $config = \Yaf_Registry::get('configarr');
            $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING);
            $database = new PDO($config['database']['dbtype'] . ':host=' . $config['database']['host'] . ';dbname=' . $config['database']['dbname'], $config['database']['username'], $config['database']['password'], $options);
            $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $database->exec('SET CHARACTER SET '.$config['database']['charset']);
            $this->$name = $database;
        } else if($name == 'validation'){
            // 表单验证类
            $this->$name = new \Validation_CValidation($this->rules(), $this->attributeLabels());
        } else {
            $this->$name = '';
        }
        return $this->$name;
    }

    /**
     * 对象属性转换成数组
     *
     */
    public function toArray($pdata) {
        $attributes = $this->attributeLabels();

        $data = array();
        foreach($pdata as $key=>$value) {
            if(isset($attributes[$key]))
                $data[$key] = Tools_help::filter($value);
        }
        return $data;
    }

    /**
     * 数组填充对象属性
     *
     */
    public function parseAttributes($data = array(), $filter=1) {
        if($data){
            foreach ($data as $key=>$value) {
                if($filter)
                    $this->$key = Tools_help::filter($data[$key]);
                else
                    $this->$key = $data[$key];
            }
        }
    }

    /*
     * 查询列表数据
     * @param $params array
     * @return array|bool
     * eg: $params = array(
     *       'field' => array('id', 'username'), 查询字段
     *       'where'  => array('username' => 'songxiyao', 'password' => 'xxxxx'), 查询条件
     *       'order'  => 'id desc', 排序
     *       'limit'  => 1, 查询的数量
     *       'offset' => 1, 查询偏移量
     *       'page'   => $page ? $page : 1, 当前页码
     *       'per'    => 1, 每页显示数量
     *     );
     */
    public function getLists($params = array('field'=>array(), 'where'=>array()), $key='') {
        $query = "";
        if (isset($params['field']) && is_array($params['field']) && !empty($params['field'])) {
            $fieldstr = Tools_help::arraytofields($params['field']);
            $query .= 'select '.$fieldstr.' from '.$this->_table;
        } else {
            $query .= 'select * from '.$this->_table;
        }

        if (isset($params['where']) && is_array($params['where']) && !empty($params['where'])) {
            $query .= ' where 1=1 ';
            foreach ($params['where'] as $k => $v) {
                $islike = strstr($v, '%');
                if($islike) {
                    $query .= ' and '.$k.' like ?';
                } else {
                    $query .= ' and '.$k.'=?';
                }
            }
        }

        if (isset($params['order']) && !empty($params['order'])) {
            $query .= ' order by '.$params['order'];
        }
        if (isset($params['limit']) && !empty($params['limit'])) {
            if (empty($params['offset'])) {
                $query .= ' limit '.$params['limit'];
            } else {
                $query .= ' limit '.$params['limit'].', '.$params['offset'];
            }
        }
        //用于翻页
        if (isset($params['page']) && !empty($params['page']) && isset($params['per']) && !empty($params['per'])) {

            $page = $params['page'];
            $rowCount = $params['per'];
            $page = ($page > 0) ? $page : 1;
            $offset = (int) $params['per'] * ($page - 1);

            $query .= ' limit '.$offset.', '.$params['per'];
        }

        if ($query) {
            $dbconn = $this->db->prepare($query);
            $dbconn->execute(array_values($params['where']));
            $result = $dbconn->fetchAll(PDO::FETCH_ASSOC);
            $dbconn->closeCursor();
        }

        // key 键值对
        $data = array();
        if($result && $key) {
            foreach($result as $value) {
                $data[$value[$key]] = $value;
            }
        } else if($result) {
            $data = $result;
        }
        return isset($data) ? $data: false;
    }


    /**
     * 单条查询
     *
     */
    public function select($params=array('where'=>array())) {
        $query = "";
        if (isset($params['field']) && is_array($params['field']) && !empty($params['field'])) {
            $fieldstr = Tools_help::arraytofields($params['field']);
            $query .= 'select '.$fieldstr.' from '.$this->_table;
        } else {
            $query .= 'select * from '.$this->_table;
        }

        if (isset($params['where']) && is_array($params['where']) && !empty($params['where'])) {
            $query .= ' where 1=1 ';
            foreach ($params['where'] as $k => $v) {
                $islike = strstr($v, '%');
                if($islike) {
                    $query .= ' and '.$k.' like ?';
                } else {
                    $query .= ' and '.$k.'=?';
                }
            }
        }

        if (isset($params['order']) && !empty($params['order'])) {
            $query .= ' order by '.$params['order'];
        }
        $query .= ' limit 1';

        $dbconn = $this->db->prepare($query);
        $dbconn->execute(array_values($params['where']));
        $result = $dbconn->fetch(PDO::FETCH_ASSOC);
        $dbconn->closeCursor();
        return isset($result) ? $result : false;
    }

    /**
     * 数据插入
     *
     */
    public function insert($pdata = array()) {
        $keys = array_keys($pdata);
        $fields = '`'.implode('`, `',$keys).'`';
        #here is my way
        $placeholder = implode(',', array_fill(0, count($pdata), '?'));

        $sql = 'INSERT INTO '.$this->_table.'('.$fields.') VALUES('.$placeholder.')';
        $dbconn = $this->db->prepare($sql);
        $row = $dbconn->execute(array_values($pdata));
        if($row) {
            $row = $this->db->lastInsertId();
        }
        $dbconn->closeCursor();
        return $row;
    }

    /**
     * 数据修改
     *
     */
    public function update($where, $pdata = array(), $wheredata=array()) {
        $query = 'update '.$this->_table.' set `'.implode('`=?,`',array_keys($pdata)).'`=?';

        if (is_array($where) && !empty($where)) {
            $query .= ' where 1=1 ';
            foreach ($where as $k => $v) {
                $islike = strstr($v, '%');
                if($islike) {
                    $query .= ' and '.$k.' like ?';
                } else {
                    $query .= ' and '.$k.'=?';
                }
            }
        } else if($where) {
            $query .= ' where '.$where;
            $where = $wheredata;
        }

        $data = array_merge($pdata, $where);
        $dbconn = $this->db->prepare($query);
        $row = $dbconn->execute(array_values($data));
        $dbconn->closeCursor();
        return $row;
    }

    /**
     * 获取条数
     *
     */
    public function getCount($params = array('where'=>array())) {
        $query = 'select count(*) from '.$this->_table;
        if (isset($params['where']) && is_array($params['where']) && !empty($params['where'])) {
            $query .= ' where 1=1 ';
            foreach ($params['where'] as $k => $v) {
                $query .= ' and '.$k.'=?';
            }
        }
        $dbconn = $this->db->prepare($query);
        $dbconn->execute(array_values($params['where']));
        $row=$dbconn->fetchColumn();
        $dbconn->closeCursor();
        return $row;
    }

    /**
     * 数据彻底删除
     *
     */
    public function delete($where=array()) {
        $query = 'delete from '.$this->_table;
        if (is_array($where) && !empty($where)) {
            $query .= ' where 1=1 ';
            foreach ($where as $k => $v) {
                $islike = strstr($v, '%');
                if($islike) {
                    $query .= ' and '.$k.' like ?';
                } else {
                    $query .= ' and '.$k.'=?';
                }
            }
        } else if(is_string($where) && !empty($where)) {
            $query .= ' where '.$where;
        }
        $dbconn = $this->db->prepare($query);
        $row = $dbconn->execute(array_values($where));
        if($row){
            $row = $dbconn->rowCount();
        }
        $dbconn->closeCursor();
        return $row;
    }
}

?>
