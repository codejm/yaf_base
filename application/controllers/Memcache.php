<?php

/**
 *      [CodeJm!] Author CodeJm[codejm@163.com].
 *
 *      首页
 *      $Id: Default.php 2014-07-27 18:10:47 codejm $
 */

class MemcacheController extends \Core_BaseCtl {

    // 默认Action
    public function indexAction() {
        $cache = Cache_Cache::create(array('host'=>'10.10.16.38', 'port'=>11211, 'persistent'=>0, 'use_memcached'=>0), Cache_Cache::TYPE_MEMCACHE);
        echo $cache->get('qqdclub_alwaysontop'); exit;
    }


    public function testAction() {
        echo $this->getg('id').'_'.$this->getg('name');
        phpinfo();
        exit;
    }
}

?>
