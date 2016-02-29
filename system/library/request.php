<?php
defined('DIR_SYSTEM') or exit('Access Invalid!');
/**
 * http请求
 * Class Request
 */

class Request {

	public $get = array();
	public $post = array();
	public $cookie = array();
	public $files = array();
	public $server = array();

    /**
     * 过滤参数，并赋值
     */
    public function __construct() {
		$_GET = $this->clean($_GET);
		$_POST = $this->clean($_POST);
		$_REQUEST = $this->clean($_REQUEST);
		$_COOKIE = $this->clean($_COOKIE);
		$_FILES = $this->clean($_FILES);
		$_SERVER = $this->clean($_SERVER);
		
		$this->get = $_GET;
		$this->post = $_POST;
		$this->request = $_REQUEST;
		$this->cookie = $_COOKIE;
		$this->files = $_FILES;
		$this->server = $_SERVER;
	}

    /**
     * 清除非法字符串
     * @param $data
     * @return array|string
     */
    public function clean($data) {
    	if (is_array($data)) {
	  		foreach ($data as $key => $value) {
				unset($data[$key]);
				
	    		$data[$this->clean($key)] = $this->clean($value);
	  		}
		} else { 
	  		$data = htmlspecialchars($data, ENT_COMPAT, 'UTF-8');
		}

		return $data;
	}
}