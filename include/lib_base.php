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
放一些基础函数
***/

//先来一个递归转义数组的函数
function _addslashes($arr) {
	foreach ($arr as $k => $v) {
		if(is_string($v)) {
			$arr[$k] = addslashes($v);
		}
		else if (is_array($v)) { //再加判断，如果是数组，再次调用自身
			$arr[$k] = _addslashes($v);
		}
	}
	return $arr;
}


?>