<?php
final class MySQL {
	private $link;

    /**
     * 初始化　连接数据库
     * @param $hostname
     * @param $username
     * @param $password
     * @param $database
     */

    public function __construct($hostname, $username, $password, $database) {
		if (!$this->link = @mysql_connect($hostname, $username, $password)) {
      		trigger_error('错误: 不能使用数据库链接 ' . $username . '@' . $hostname);
		}

    	if (!mysql_select_db($database, $this->link)) {
      		trigger_error('错误:无法连接数据库 ' . $database);
    	}
		
		mysql_query("SET NAMES 'utf8'", $this->link);
		mysql_query("SET CHARACTER SET utf8", $this->link);
		mysql_query("SET CHARACTER_SET_CONNECTION=utf8", $this->link);
		mysql_query("SET SQL_MODE = ''", $this->link);
  	}

    /**
     * 查询
     * @param $sql
     * @return bool|stdClass
     */
    public function query($sql) {
		if ($this->link) {
			$resource = mysql_query($sql, $this->link);
	
			if ($resource) {
				if (is_resource($resource)) {
					$i = 0;
			
					$data = array();
			
					while ($result = mysql_fetch_assoc($resource)) {
						$data[$i] = $result;
			
						$i++;
					}
					
					mysql_free_result($resource);
					
					$query = new stdClass();
					$query->row = isset($data[0]) ? $data[0] : array();
					$query->rows = $data;
					$query->num_rows = $i;
					
					unset($data);
					
					return $query;	
				} else {
					return true;
				}
			} else {
				trigger_error('Error: ' . mysql_error($this->link) . '<br />Error No: ' . mysql_errno($this->link) . '<br />' . $sql);
				exit();
			}
		}
  	}

    /**
     * 过滤
     * @param $value
     * @return string
     */

    public function escape($value) {
		if ($this->link) {
			return mysql_real_escape_string($value, $this->link);
		}
	}

    /**
     * 返回影响行数
     * @return int
     */

    public function countAffected() {
		if ($this->link) {
    		return mysql_affected_rows($this->link);
		}
  	}

    /**
     * 获取最后一个id
     * @return int
     */
    public function getLastId() {
		if ($this->link) {
    		return mysql_insert_id($this->link);
		}
  	}

    /**
     * 关闭连接
     */
    public function __destruct() {
		if ($this->link) {
			mysql_close($this->link);
		}
	}
}
?>