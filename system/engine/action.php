<?php
defined('DIR_SYSTEM') or exit('Access Invalid!');
/**
 * 动作类
 * Class Action
 */
final class Action {

    protected $file;
	protected $class;
	protected $method;
	protected $args = array();

    /**
     * 主要是拆分请求
     * @param $route
     * @param array $args
     */
    public function __construct($route, $args = array()) {
		$path = '';
		$parts = explode('/', str_replace('../', '', (string)$route));
		foreach ($parts as $part) {
			$path .= $part;
			if (is_dir(DIR_APPLICATION . DIR_CONTROLLER . DS . $path)) {
				$path .= '/';
				array_shift($parts);
				continue;
			}
            if (is_file(DIR_APPLICATION . DIR_CONTROLLER . DS . str_replace(array('../', '..\\', '..'), '', $path) . '.php')) {
                $this->file = DIR_APPLICATION . DIR_CONTROLLER . DS . str_replace(array('../', '..\\', '..'), '', $path) . '.php';
                $temp_path = explode('/', str_replace('../', '', (string)$path));
                $this->class =end($temp_path);
				array_shift($parts);
				break;
			}
		}

		if ($args) {
			$this->args = $args;
		}

		$method = array_shift($parts);

		if ($method) {
			$this->method = $method;
		} else {
			$this->method = 'index';
		}
	}

    /**
     * 获取类文件
     * @return mixed
     */
    public function getFile() {
		return $this->file;
	}

    /**
     * 获取类名
     * @return mixed
     */
    public function getClass() {
		return $this->class;
	}

    /**
     * 获取动作
     * @return mixed
     */
    public function getMethod() {
		return $this->method;
	}

    /**
     * 获取参数
     * @return array
     */
    public function getArgs() {
		return $this->args;
	}
}