<?php

/**
 *      [CodeJm!] Author CodeJm[codejm@163.com].
 *
 *      Memcache封装类，支持memcache和memcached两种扩展
 *      $Id: Memcache.php 2014-08-26 14:44:22 codejm $
 */

class Cache_Memcache {

    /**
     * memcached扩展采用libmemcache，支持更多特性，更标准通用
     */
    protected $memcached = false;
    protected $cache;
    //启用压缩
    protected $set_flags = 0;

    function __construct($config) {
        if (empty($config['use_memcached'])) {
            $this->set_flags = MEMCACHE_COMPRESSED;
            $this->cache = new \Memcache();
        } else {
            $this->cache = new \Memcached();
            $this->memcached = true;
        }

        if (isset($config['compress']) and $config['compress']===false) {
            $this->set_flags = 0;
        }

        if (empty($config['servers'])) {
            $this->addServer($config);
        } else {
            foreach($config['servers'] as $cf) {
                $this->addServer($cf);
            }
        }
    }

    /**
     * 格式化配置
     * @param $cf
     * @return null
     */
    protected function formatConfig(&$cf) {
        if (empty($cf['host'])) $cf['host'] = 'localhost';
        if (empty($cf['port'])) $cf['port'] = 11211;
        if (empty($cf['weight'])) $cf['weight'] = 1;
        if (empty($cf['persistent'])) $cf['persistent'] = false;
    }

    /**
     * 增加节点服务器
     * @param $cf
     * @return null
     */
    protected function addServer($cf) {
        $this->formatConfig($cf);
        if ($this->memcached) $this->cache->addServer($cf['host'], $cf['port'], $cf['weight']);
        else $this->cache->addServer($cf['host'], $cf['port'], $cf['persistent'], $cf['weight']);
    }

    /**
     * 获取数据
     * @see libs/system/ICache#get($key)
     */
    function get($key) {
        return $this->cache->get($key);
    }

    function set($key, $value, $expire = 0) {
        if ($this->memcached) {
            return $this->cache->set($key, $value, $expire);
        } else {
            return $this->cache->set($key, $value, $this->set_flags, $expire);
        }
    }

    function delete($key) {
        return $this->cache->delete($key);
    }

    function __call($method,$params) {
        return call_user_func_array(array($this->cache,$method),$params);
    }
}
