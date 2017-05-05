<?php 
/****
布尔教育 高端PHP培训
培  训: http://www.itbool.com
论  坛: http://www.zixue.it
****/
header('Content-type: text/html; charset=UTF8'); 
date_default_timezone_set('Asia/Shanghai');
defined("ACC") || exit("暗戳戳的不要访问");

class CateModel extends Model {
	protected $table = "cate";
	public function add($data) {
		return $this->db->autoExecute($data,$this->table,"insert");
	}
}

?>