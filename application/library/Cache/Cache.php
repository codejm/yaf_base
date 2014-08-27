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
	const TYPE_APC = 1;
	const TYPE_XCACHE = 2;
	const TYPE_MEMCACHE = 3;
	const TYPE_EAC = 4;

	static $backends = array('FileCache', 'ApcCache', 'XCache', 'Memcache', 'EAcceleratorCache');

	/**
	 * 获取缓存对象
	 * @param $scheme
	 * @return cache object
	 */
	static function create($config) {
        if(empty(self::$backends[$config['type']])){
            die("Cache Error:cache backend: {$config['type']} no support");
        }
		$backend = "\Cache_".self::$backends[$config['type']];
		return new $backend($config);
	}
}
