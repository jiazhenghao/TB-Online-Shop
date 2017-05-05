<?php 
/****
布尔教育 高端PHP培训
培  训: http://www.itbool.com
论  坛: http://www.zixue.it
****/
header('Content-type: text/html; charset=UTF8'); 
date_default_timezone_set('Asia/Shanghai');

define("ACC",true);
require("../include/init.php");
/***
file cateaddAct.php
作用：接收cateadd.php表单页面发送来的数据，并调用model，把数据入库
***/

//第一步	接收数据
//print_r($_POST);
//第二步	检验数据
$data = array();
if (empty($_POST["cat_name"])) {
	exit("栏目名不能为空");
}
$data["cat_name"] = $_POST["cat_name"];
if (empty($_POST["intro"])) {
	exit("栏目简介不能为空");
}
$data["intro"] = $_POST["intro"];
$data["parent_id"] = $_POST["parent_id"];
//print_r($data);

//第三步	实例化model	并调用model的相关方法
$model = new CategoryModel();
if ($model->add($data)) {
	echo "栏目添加成功";
}
else {
	echo "栏目添加失败";
}

?>