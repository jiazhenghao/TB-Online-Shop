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

/**
接收goods_id
调用trash方法
**/

if (isset($_GET['act']) && $_GET['act'] == 'show') {
    //这个部分是打印所有的回收商品用的
    $goods = new GoodsModel();
    $goodslist = $goods->getTrash();
    include(ROOT."view/admin/templates/goodslist.html");
}
else {
    $goods_id = $_GET['goods_id'] + 0;
    $goods = new GoodsModel();
    if ($goods->trash($goods_id)) {
        echo "加入回收站成功";
    }
    else {
        echo "加入回收站失败";
    }
}



?>