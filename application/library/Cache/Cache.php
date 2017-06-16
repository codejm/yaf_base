<?php

/**
 *      [CodeJm!] Author CodeJm[codejm@163.com].
 *
 *      缓存基类
 *      $Id: Cache.php 2014-08-26 14:31:51 codejm $
 */

class Cache_Cache {
	public $cache;

	const TYPE_FILE = 0;
	const TYPE_MEMCACHE = 1;
	const TYPE_APC = 2;
	const TYPE_XCACHE = 3;
	const TYPE_EAC = 4;

	static $backends = array('FileCache', 'Memcache', 'ApcCache', 'XCache', 'EAcceleratorCache');

	/**
	 * 获取缓存对象
	 * @param $scheme
	 * @return cache object
	 */
	static function create($config, $type=-1) {
        if($type >= 0) {
            $t = self::$backends[$type];
        } else {
            if(!isset($config['type']))
                $config['type'] = 0;
            $t = self::$backends[$config['type']];
        }
        if(empty($t)){
            die("Cache Error:cache backend: {$config['type']} no support");
        }
		$backend = "Cache_".$t;
		return new $backend($config);
	}
}
