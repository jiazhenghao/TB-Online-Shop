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
这是数据库类
目前采用什么数据库，还不清楚
***/
abstract class DataBase {
	/*
	连接服务器
	$h 服务器地址
	$u 用户名
	$p 密码
	return bool
	*/
	public abstract function connect($h,$u,$p);
	/*
	发送查询
	$sql 发送的sql语句
	return mix
	可以是布尔值
	可以是一个资源rs
	*/
	public abstract function query($sql);
	/*
	查询多行语句
	$sql select型语句
	return array/bool
	*/
	public abstract function getAll($sql);
	/*
	查询单行语句
	$sql select型语句
	return array/bool
	*/
	public abstract function getRow($sql);
	/*
	查询单个数据
	$sql select型语句
	return array/bool
	*/
	public abstract function getOne($sql);
	/*
	自动执行insert/update语句
	拼接sql
	$this->autoExecute("user", array('username' => "zhangsan", 'email' => "zhangsan@qq.com"),"insert");
	将自动生成insert into user (username, email) values ("zhangsan", "zhangsan@qq.com");
	*/
	public abstract function autoExecute($table,$data,$act="insert",$where="");

}






?>