<?php
header('Content-type: text/html; charset=UTF8'); 
date_default_timezone_set('Asia/Shanghai');

define('ACC',true);
require('./include/init.php');

/*
if(!isset($_SESSION['useid'])){
     echo "请登录";
     exit();
}
不登录就滚蛋了
*/

$cat_id = isset($_GET['cat_id'])? $_GET['cat_id']+0:0;
$page = isset($_GET['page'])? $_GET['page']+0:1;
if($page < 1) {
    $page = 1;
}

$goodsModel = new GoodsModel();
$total = $goodsModel->catGoodsCount($cat_id);
// 每页取2条
$perpage = 2;

if($page > ceil($total/$perpage)) {
    $page = 1;
}
$offset = ($page-1)*$perpage;
$pagetool = new PageTool($total,$page,$perpage);
$pagecode = $pagetool->show();





$cat = new CategoryModel();
$category = $cat->find($cat_id);
if (empty($category)) {
    header('location: index.php');
    exit;
}//如果不存在，说明cat_id是个假的，就回到首页去吧

//取出树状导航
$cats = $cat->select();//获取所有栏目
$sort = $cat->getCatTree($cats,0,1);

//取出面包屑导航
$nav = $cat->getFather($cats,$cat_id);//找家谱树


//取出栏目下的商品
$goods = new GoodsModel();
$goodslist = $goods->catGoods2($cat_id,$offset,$perpage);

include(ROOT . 'view/front/lanmu.html');


?>