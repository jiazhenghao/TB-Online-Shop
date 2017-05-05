<?php 
/****
布尔教育 高端PHP培训
培  训: http://www.itbool.com
论  坛: http://www.zixue.it
****/
header('Content-type: text/html; charset=UTF8'); 
date_default_timezone_set('Asia/Shanghai');

defined("ACC") || exit("暗戳戳的不要访问");

/***
conf.class.php
配置文件读写类
单例模式
***/
class conf {
	protected static $ins = null;
	protected $data = array();
	final protected function __construct() {
		include(ROOT."include/config.inc.php");//一次性把配置文件信息读过来，这样以后不用管配置文件了
		$this->data = $_CFG;//已经读取到$_CFG
	}
	final protected function __clone() {
		
	}
	public static function getIns() {
		if (self::$ins instanceof self) {
            return self::$ins;
        }
        else {
            self::$ins = new self();
            return self::$ins;
        }
	}

	//用魔术方法读取data内的信息
	public function __get($key) {
		if (array_key_exists($key,$this->data)) {
			return $this->data[$key];
		} 
		else {
			return null;
		}
	}
	//用魔术方法在运行期间增加或改变配置选项
	public function __set($key, $value) {
		$this->data[$key] = $value;
	}
}

?>