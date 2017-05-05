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

$cat = new CategoryModel();
$catlist = $cat->select();
$catlist = $cat->getCatTree($catlist, 0, 0);

include(ROOT."view/admin/templates/goodsadd.html");


?>