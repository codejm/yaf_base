<?php

/**
 *      [CodeJm!] Author CodeJm[codejm@163.com].
 *
 *      首页
 *      $Id: Default.php 2014-07-27 18:10:47 codejm $
 */

class RedisController extends \Core_BaseCtl {

    // 默认Action
    public function indexAction() {

        $redis = new Redis();
        echo '<pre>'; var_dump($redis); echo '</pre>'; die();
        $redis->connect("127.0.0.1", "6379");
        $redis->lPush('swoole:queue', 'a:2:{s:4:"type";s:5:"Hllo2";s:4:"data";a:1:{s:1:"a";s:14:"Hllo1496918299";}}');

        exit;
        $redis = new Redis();
        $redis->connect("10.10.16.63", "6389");
        $redis->select(3);
        $keys = $redis->keys('bus_tcp_*');
        echo $redis->delete($keys);

        exit;
        $redispost = new Redis();
        $redispost->connect("10.10.16.62","6379");
        $redispost->select(7);
        echo $redispost->get('club_64_5189055_0');
        exit;
        $arr = array(
            '10.10.16.61:6379',
            '10.10.16.61:6389',
            '10.10.16.62:6379',
            '10.10.16.62:6389',
            '10.10.16.63:6379',
            '10.10.16.63:6389',
            '10.10.16.90:6379',
            '10.10.16.90:6389',
            '10.10.16.91:6379',
            '10.10.16.91:6389'
        );

        foreach ($arr as $value) {
            list($ip, $port) = explode(':', $value);
            $t1 = microtime(true);
            for($i=0; $i<10; $i++){
                $redis = new Redis();
                $redis->connect($ip, $port);
                $redis->set('codejm', 'test');
                $redis->get('codejm');
                $redis->del('codejm');
            }
            $t2 = microtime(true);
            echo $value.'耗时'.round($t2-$t1,3).'秒<br />';
        }
        die();
    }

    /**
     * wxpay 查询错误原因
     */
    public function wxpayNotileAction() {
        /* {{{ */
        $redispost = new Redis();
        $redispost->connect("10.10.16.63","6389");
        echo $redispost->hGet('wxpay_thirdpay_notify_list', '20170302091454634213999499028346');
        exit;
        /* }}} */
    }

    /**
     * 清理社区关键字缓存
     */
    public function clearKeywordAction() {
        /* {{{ */
        $redispost = new Redis();
        $redispost->connect("10.10.16.63","6389");
        $redispost->select(1);
        // 进入审核
        $redispost->delete('badword_common');
        // 进入回收站
        $redispost->delete('badword_cate');
        exit;
        /* }}} */
    }

    public function clearredis63_6379Action() {
        /* {{{ */
        $redis = new Redis();
        $redis->connect("10.10.16.63","6379");
        $redis->select(3);

        for ($i = 11; $i < 99; $i++) {
            echo $i."\n";
            $keys = $redis->keys('passport_userinfo_uid'.$i.'*');
            foreach ($keys as $key) {
                //$key = 'passport_userinfo_uid'.$uid;
                $lasttime = $redis->hGet($key, 'lastlogintime');
                $lasttime = strtotime($lasttime);
                if($lasttime < (time()-31*86400)) {
                    $redis->delete($key);
                }
            }
        }
        exit;
        /* }}} */
    }

    public function clearredis90_6379Action() {
        /* {{{ */
        $redis = new Redis();
        $redis->connect("10.10.16.62","6379");
        $redis->select(1);
        $keys = $redis->keys('club_zt_huatan_*');
        $redis->delete($keys);
        exit;

        for ($i = 11; $i < 99; $i++) {
            echo $i."\n";
            $keys = $redis->keys('passport_user_gold_hash_'.$i.'*');
            $redis->delete($keys);
        }
        exit;
        /* }}} */
    }
}

?>
