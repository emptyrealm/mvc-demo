<?php
defined('DIR_SYSTEM') or exit('Access Invalid!');
/**
 * 加载类
 * Class Loader
 */
final class Loader {

	protected $registry;

    /**
     * 初始化注册类，用于注册该类属性值
     * @param $registry
     */
    public function __construct($registry) {
		$this->registry = $registry;
	}

    /**
     * @param $key
     * @return mixed
     */
    public function __get($key) {
		return $this->registry->get($key);
	}

    /**
     * @param $key
     * @param $value
     */
    public function __set($key, $value) {
		$this->registry->set($key, $value);
	}

    /**
     * 加载library文件
     * @param $library
     */
    public function library($library) {
		$file = DIR_SYSTEM . DIR_LIBRARY . DS . $library . '.php';
		
		if (file_exists($file)) {
			include_once($file);
		} else {
			trigger_error('错误:无法加载library' . $library . '!');
			exit();					
		}
	}

    /**
     * 加载帮助类，虽然还没有数据
     * @param $helper
     */
    public function helper($helper) {
		$file = DIR_SYSTEM . DIR_HELPER . DS . $helper . '.php';
		
		if (file_exists($file)) {
			include_once($file);
		} else {
			trigger_error('错误:无法加载 helper ' . $helper . '!');
			exit();					
		}
	}

    /**
     * 加载model
     * @param $model
     * @param string $aliases
     */

    public function model($model,$aliases='') {
		$file  = DIR_APPLICATION . DIR_MODEL . DS . $model . '.php';
        $parts = explode('/', str_replace('../', '', (string)$model));
		$class =end($parts).'_model';
        $aliases=$aliases?$aliases:$class;
		if (file_exists($file)) {
			include_once($file);
			
			$this->registry->set($aliases, new $class($this->registry));
		} else {
			trigger_error('错误:无法加载 model ' . $model . '!');
			exit();					
		}
	}

    /**
     * 加载数据库驱动文件
     * @param $driver
     * @param $hostname
     * @param $username
     * @param $password
     * @param $database
     */

    public function database($driver, $hostname, $username, $password, $database) {
		$file  = DIR_SYSTEM . DIR_DATABASE . DS . $driver . '.php';
		$class = 'Database' . preg_replace('/[^a-zA-Z0-9]/', '', $driver);
		
		if (file_exists($file)) {
			include_once($file);
			
			$this->registry->set(str_replace('/', '_', $driver), new $class($hostname, $username, $password, $database));
		} else {
			trigger_error('错误:无法加载 database ' . $driver . '!');
			exit();				
		}
	}


}