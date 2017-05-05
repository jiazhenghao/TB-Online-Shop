<?php 
/****
布尔教育 高端PHP培训
培  训: http://www.itbool.com
论  坛: http://www.zixue.it
****/
header('Content-type: text/html; charset=UTF8'); 
date_default_timezone_set('Asia/Shanghai');

//允许访问的文件都必须要有常量ACC
define("ACC",true);

//所有用户直接访问的页面，必须先加载init.php
require("../include/init.php");

//栏目的删除页面
/***
思路：
接收cat_id
调用model
删除cat_id
***/
$cat_id = $_GET['cat_id'] + 0;
$cat = new CategoryModel();

/*
判断该栏目是否有子栏目，
如果有，就不能删除
思路：取出子孙数组，如果为空，则可以删除
*/

$catlist = $cat->select();
$arr = $cat->getCatTree($catlist, $id = $cat_id, $lev = 0);//查子孙数，如果为空，则可以删除，如果不为空，则不可以删除
//也可以查子栏目，新增的getSons函数。这里不做演示
if ( empty($arr) ){
    if ($cat->delete($cat_id)) {
        //echo   "删除成功";
        $cat = new CategoryModel();
        $catlist = $cat->select();
        $catlist = $cat->getCatTree($catlist, 0, 0);
        include(ROOT."view/admin/templates/catelist.html");
    }
    else {
        echo '删除失败';
    }
}
else {
    exit("不可以删除");
    //echo "不可以删除";
}

?>