<?php

/**
 *      [CodeJm!] Author CodeJm[codejm@163.com].
 *
 *      EAccelerator缓存，安装EAccelerator加速器后可以使用
 *      警告：EAccelerator缓存不适用于分布式环境
 *      $Id: EAcceleratorCache.php 2014-08-26 14:42:08 codejm $
 */

class Cache_EAcceleratorCache {
	function __construct($config) {
		if (!function_exists('eaccelerator_get')) {
			die('EAccelerator extension didn\'t installed');
		}
	}

	/**
	 * 设置缓存
	 * @see libs/system/ICache#set($key, $value, $expire)
	 */
	function set($key,$value,$timeout=0) {
		return \eaccelerator_put($key,$value,$timeout);
	}

	/**
	 * 读取缓存
	 * @see libs/system/ICache#get($key)
	 */
	public function get($key) {
		return \eaccelerator_get($key);
	}

	/**
	 * 清空缓存
	 */
	public function clear() {
		\eaccelerator_clear();
	}

	/**
	 * 删除缓存
	 * @return true/false
	 */
	public function delete($key) {
		return \eaccelerator_rm($key);
	}
}
