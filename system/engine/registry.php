<?php
defined('DIR_SYSTEM') or exit('Access Invalid!');
/**
 * 注册类
 * Class Registry
 */
final class Registry {

	private $data = array();

    /**
     * 获取
     * @param $key
     * @return null
     */
    public function get($key) {
		return (isset($this->data[$key]) ? $this->data[$key] : NULL);
	}

    /**
     * 设置
     * @param $key
     * @param $value
     */
    public function set($key, $value) {
		$this->data[$key] = $value;
	}

    /**
     * 检查是否存在
     * @param $key
     * @return bool
     */

    public function has($key) {
    	return isset($this->data[$key]);
  	}

}