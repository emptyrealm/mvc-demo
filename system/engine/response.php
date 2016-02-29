<?php
defined('DIR_SYSTEM') or exit('Access Invalid!');

/**
 * Class Response
 */
class Response {

	private $headers = array(); 
	private $level = 0;
	private $output;

    /**
     * 添加头部
     * @param $header
     */

    public function addHeader($header) {
		$this->headers[] = $header;
	}

    /**
     * 跳转
     * @param $url
     */

    public function redirect($url) {
		header('Location: ' . $url);
		exit;
	}

    /**
     * 页面压缩等级
     * @param $level
     */

    public function setCompression($level) {
		$this->level = $level;
	}

    /**
     * 设置输出内容
     * @param $output
     */

    public function setOutput($output) {
		$this->output = $output;
	}

    /**
     *
     * @param $data
     * @param int $level
     * @return string
     */
    private function compress($data, $level = 0) {

		if (isset($_SERVER['HTTP_ACCEPT_ENCODING']) && (strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') !== false)) {
			$encoding = 'gzip';
		} 

		if (isset($_SERVER['HTTP_ACCEPT_ENCODING']) && (strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'x-gzip') !== false)) {
			$encoding = 'x-gzip';
		}

		if (!isset($encoding)) {
			return $data;
		}

		if (!extension_loaded('zlib') || ini_get('zlib.output_compression')) {
			return $data;
		}

		if (headers_sent()) {
			return $data;
		}

		if (connection_status()) { 
			return $data;
		}
		
		$this->addHeader('Content-Encoding: ' . $encoding);

		return gzencode($data, (int)$level);
	}

    /**
     * 输出内容
     */
    public function output() {
		if ($this->output) {
			if ($this->level) {
				$ouput = $this->compress($this->output, $this->level);
			} else {
				$ouput = $this->output;
			}	
				
			if (!headers_sent()) {
				foreach ($this->headers as $header) {
					header($header, true);
				}
			}
			
			echo $ouput;
		}
	}
}