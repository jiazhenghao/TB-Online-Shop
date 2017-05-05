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


/*
作用：编辑栏目
思路：
接收cat_id
实例化model，调用model，取出栏目信息
展示到表单
*/

$cat_id = $_GET["cat_id"] + 0; 
$cat = new CategoryModel();
$catinfo = $cat->find($cat_id);

$catlist = $cat->select();
$catlist = $cat->getCatTree($catlist, 0, 0);

include(ROOT."view/admin/templates/cateeditview.php");




?>