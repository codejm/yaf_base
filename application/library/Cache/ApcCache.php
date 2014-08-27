<?php

/**
 *      [CodeJm!] Author CodeJm[codejm@163.com].
 *
 *      APC缓存，安装APC加速器后可以使用
 *      警告：apc缓存不适用于分布式环境
 *      $Id: ApcCache.php 2014-08-26 14:37:23 codejm $
 */

class Cache_ApcCache {

	function __construct($config) {
		if (!function_exists('apc_cache_info')) {
			die('没有安装APC扩展');
		}
	}

	/**
	 * 设置缓存
	 * @see libs/system/ICache#set($key, $value, $expire)
	 */
	function set($key,$value,$timeout=0) {
		return \apc_store($key,$value,$timeout);
	}

	/**
	 * 读取缓存
	 * @see libs/system/ICache#get($key)
	 */
	public function get($key) {
		return \apc_fetch($key);
	}

	/**
	 * 清空缓存
	 */
	public function clear() {
		return \apc_clear_cache();
	}

	/**
	 * 删除缓存
	 * @return true/false
	 */
	public function delete($key) {
		return \apc_delete($key);
	}
}
