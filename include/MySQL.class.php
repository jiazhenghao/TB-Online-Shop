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
这里我们继承自DataBase类
实现抽象的方法

我们也配置单例模式

***/

class MySQL extends DataBase {
	private static $ins = NULL;
	private $conn = NULL;
	private $conf = array();

	protected function __construct() {
		$this->conf = conf::getIns();

		$this->connect($this->conf->host,$this->conf->user,$this->conf->pwd);

		$this->select_db($this->conf->db);//这个还没有实现

		$this->setChar($this->conf->char);
		//这个好像没有的，在$conf里面没有char这个变量
		//但很巧妙的是conf.class.php里面有魔术方法实现了这种操作
	}

	public function __destruct() {
	}

	public static function getIns() {
		if (self::$ins == false) { //不要用===
			self::$ins = new self();
		}
		return self::$ins;
	}

	/*连接服务器$h 服务器地址 $u 用户名 $p 密码return bool*/
	public function connect($h,$u,$p) {
		$this->conn = mysql_connect($h,$u,$p);
		if (!$this->conn) {
			$err = new Exception("连接失败");
			throw $err;
		}
	}

	//选择数据库
	protected function select_db($db) {
		$sql = "use ".$db;
		return $this->query($sql);
	}

	//设置字符集
	protected function setChar($char) {
		$sql = "set names ".$char;
		return $this->query($sql);
	}

	//发送查询	$sql 发送的sql语句	return mix  可以是布尔值 可以是一个资源rs
	public function query($sql) {
        Log::write($sql);
		return mysql_query($sql, $this->conn);
	}

	/*查询多行语句	$sql select型语句	return array/bool*/
	public function getAll($sql) {
		$list=array();
        $rs = $this->query($sql);
        if (!$rs)
            return false;
        while($row = mysql_fetch_assoc($rs)) {
            $list[] = $row;
        }
        return $list;
	}
	
	/*
	自动执行insert/update语句
	拼接sql
	$this->autoExecute("user", array('username' => "zhangsan", 'email' => "zhangsan@qq.com"),"insert");
	将自动生成insert into user (username, email) values ("zhangsan", "zhangsan@qq.com");
	*/
	public function autoExecute($arr,$table,$mode="insert",$where=" where 1 limit 1") {
		if (!is_array($arr)) {
			return false;
		}
		if ($mode == "update") {
			$sql = "update ".$table." set ";
			foreach ($arr as $k => $v) {
				$sql .= $k."='".$v."',";
			}
			$sql = rtrim($sql, ",");
			$sql .= $where;
			return $this->query($sql);
		}
		else if ($mode == "insert") {
			$sql = "insert into ".$table." (";
			foreach ($arr as $k => $v) {
				$sql.=$k.",";
			}
			$sql = rtrim($sql, ",");
			$sql .=") values (";
			foreach ($arr as $k => $v) {
				$sql.="'".$v."'".",";
			}
			$sql = rtrim($sql, ",");
			$sql .=")";
			return $this->query($sql);
		}
		else {
			return false;
		}
	}


	//查询单行语句	$sql select型语句  return array/bool
	public function getRow($sql) {
		$rs = $this->query($sql);
		return mysql_fetch_assoc($rs);
	}

	//查询单个数据  $sql select型语句  return array/bool
	public function getOne($sql) {
		$rs = $this->query($sql);
		$row = mysql_fetch_row($rs);
		return $row[0];
	}

	//返回影响行数的函数
	public function affected_rows() {
		return mysql_affected_rows($this->conn);
	}

	//返回最新的auto_increment列的自增长的值
	public function insert_id() {
		return mysql_insert_id($this->conn);
	}
}
?>