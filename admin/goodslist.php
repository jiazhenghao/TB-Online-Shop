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
实例化GoodsModel
调用select方法
循环显示在view上
*/
$goods = new GoodsModel();
$goodslist = $goods->getGoods();

include(ROOT."view/admin/templates/goodslist.html");


?>