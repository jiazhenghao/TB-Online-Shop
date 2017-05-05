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
接收goods_id
实例化GoodsModel
调用find方法
展示商品信息
*/
$goods_id = $_GET['goods_id'] + 0;
$goods = new GoodsModel();
$goodsinfo = $goods->find($goods_id);
if (empty($goodsinfo)) {
    exit('商品不存在');
}
print_r($goodsinfo);


?>