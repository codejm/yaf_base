<?php

/**
 *      [CodeJm!] Author CodeJm[codejm@163.com].
 *
 *      Mysql
 *      $Id: Default.php 2014-07-27 18:10:47 codejm $
 */

class MysqlController extends \Core_BaseCtl {

    // 默认Action
    public function indexAction() {
        Yaf_Dispatcher::getInstance()->disableView();
        // 数据库延迟时间
        $this->salve('10.10.16.88');
        echo "<br />\n";
        $this->salve('10.10.16.16');
        echo "<br />\n";
        //$this->salve('10.10.16.37');
        //echo "<br />\n";
        //$this->salve('10.10.16.89');

    }

    /**
     * 获取指定发帖人信息 ip, time
     *
     */
    public function getIpTimeAction($author='一本初衷') {
        /* {{{ */
        $author = iconv('utf-8', 'gb2312//IGNORE', $author);
        $db = $this->getDB('10.10.16.16', 'qdrbs_22');
        $sql = 'show tables like \'%m_topic%\' ';
        $result = $db->prepare($sql);
        $result->execute();
        $data = $result->fetchAll(PDO::FETCH_ASSOC);
        $result->closeCursor();

        foreach ($data as $value) {
            $value = array_values($value);
            $tablename = $value[0];
            if(!preg_match("/^m_topic[0-9]+$/", $tablename, $m)){
                continue;
            }
            if($tablename == 'm_topic1095')
                continue;

            // $startindex = ($page-1)*$pagesize;
            // ' limit '.$startindex.','.$pagesize
            $sql = 'select author, author_host,create_dt  from '.$tablename." where author='{$author}'";
            $result = $db->prepare($sql);
            $result->execute();
            $topicList = $result->fetchAll(PDO::FETCH_ASSOC);
            $result->closeCursor();
            if($topicList) {
                foreach ($topicList as $value) {
                    $value['author'] = iconv('gb2312', 'utf-8//IGNORE', $value['author']);
                    echo "{$value['author']}\t\t{$value['author_host']}\t\t{$value['create_dt']}\n";
                }
            }
        }
        exit;
        /* }}} */
    }


    /**
     * 主从延迟
     */
    public function salve($ip) {
        /* {{{ */
        $db = $this->getDB($ip);
        $sql = 'SHOW SLAVE STATUS';
        $result = $db->prepare($sql);
        $result->execute();
        $data = $result->fetch(PDO::FETCH_ASSOC);
        echo $ip."数据库延迟时间:<br />\n";
        echo $data['Seconds_Behind_Master']."s<br />\n";
        echo ($data['Seconds_Behind_Master']/3600)."h<br />\n";
        $result->closeCursor();
        return $data['Seconds_Behind_Master'];
        /* }}} */
    }

    public function getDB($host='10.10.16.37', $dbname='qdrbs', $username='apiU', $pwd='nvpio20q23') {
        /* {{{ */
        $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING);
        $config = array('database'=>array(
            'dbtype' => 'mysql',
            'host' => $host,
            'dbname' => $dbname,
            'username' => $username,
            'password' => $pwd
        ));
        $database = new PDO($config['database']['dbtype'] . ':host=' . $config['database']['host'] . ';dbname=' . $config['database']['dbname'], $config['database']['username'], $config['database']['password'], $options);
        $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $database;
        /* }}} */
    }

    public function upMpAction() {
        /* {{{ */
        $page = 1;
        $pagesize = 100;

        do {
            echo 'curr page:'.$page."\n";
            $db = $this->getDB('10.10.50.122', 'api');
            $startindex = ($page-1)*$pagesize;
            $sql = 'select * from crawler_mp_articles order by id asc limit '.$startindex.','.$pagesize;
            $result = $db->prepare($sql);
            $result->execute();
            $data = $result->fetchAll(PDO::FETCH_ASSOC);
            $result->closeCursor();

            if($data) {
                foreach ($data as $value) {
                    /*$value['url'] = 'http://mp.weixin.qq.com/s?__biz=MjM5OTI1MDU4MA==&mid=2704215030&idx=1&sn=123e476ece091870245e724f677570c2&chksm=83e5f40db4927d1bd2d2ca6d900c743ff2ede79e9c8f9619fca6dea33f2e8703dea2df706161&scene=27#wechat_redirect';
                    $value['id'] = 120168;*/
                    $url = $value['url'];
                    $content = Tools_help::getget($url);
                    if($content && preg_match('#<em id="post-date" class="rich_media_meta rich_media_meta_text">(.*?)</em>#', $content, $matchs)) {
                        $date = strtotime($matchs[1]);
                        if($date) {
                            $sql = 'update crawler_mp_articles set create_time='.$date.' where id='.$value['id'];
                            $result = $db->prepare($sql);
                            $row = $result->execute();
                            $result->closeCursor();
                        }
                    }
                }
            }
            $page++;
        } while ($data);
        die();
        /* }}} */
    }

    public function emojiTestAction() {
        /* {{{ */
        $db = $this->getDB('10.10.50.83', 'test', 'root', '123456');

        $sql = 'update test set name=\'sss😈ssss\' where id=1';
        $result = $db->prepare($sql);
        $row = $result->execute();
        $result->closeCursor();

        $sql = 'select * from test limit 1';
        $result = $db->prepare($sql);
        $result->execute();
        $data = $result->fetch(PDO::FETCH_ASSOC);
        $result->closeCursor();
        echo '<pre>'; var_dump($data); echo '</pre>'; die();
        /* }}} */
    }
}

?>
