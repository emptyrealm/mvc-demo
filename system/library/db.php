<?php
defined('DIR_SYSTEM') or exit('Access Invalid!');
class DB {
	private $driver;

    /**
     * 初始化数据库驱动
     * @param $driver
     * @param $hostname
     * @param $username
     * @param $password
     * @param $database
     */

    public function __construct($driver, $hostname, $username, $password, $database) {
		if (file_exists(DIR_SYSTEM.DIR_DATABASE . DS . $driver . FILE_SUFFIX)) {
			require_once(DIR_SYSTEM.DIR_DATABASE . DS . $driver . FILE_SUFFIX);
		} else {
			exit('错误: 无法加载数据库文件' . $driver . '!');
		}
				
		$this->driver = new $driver($hostname, $username, $password, $database);
	}

    /**
     * 查询sql
     * @param $sql
     * @return mixed
     */
    public function query($sql) {
		return $this->driver->query($sql);
  	}

    /**
     * 过滤
     * @param $value
     * @return mixed
     */

    public function escape($value) {
		return $this->driver->escape($value);
	}

    /**
     * 返回受影响的数
     * @return mixed
     */
    public function countAffected() {
		return $this->driver->countAffected();
  	}

    /**
     * 返回最后一次id
     * @return mixed
     */

    public function getLastId() {
		return $this->driver->getLastId();
  	}	
}
?>