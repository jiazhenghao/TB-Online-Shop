<?php
header('Content-type: text/html; charset=UTF8'); 
date_default_timezone_set('Asia/Shanghai');

define('ACC',true);
require('./include/init.php');

$goods_id = isset($_GET['goods_id'])?$_GET['goods_id']+0:0;


$smarty->caching = true;
$smarty->cache_lifetime = 60;
if (!$smarty->isCached('smarty_shangpin.html', $goods_id)) {
    // 先查询这个商品信息
    $goods = new GoodsModel();
    $g = $goods->find($goods_id);
    if(empty($g)) {
        header('location: index.php');
        exit();
    }
    $cat = new CategoryModel();
    $cats = $cat->select();//获取所有栏目
    $nav = $cat->getFather($cats,$g['cat_id']);//找家谱树
    $smarty->assign('g', $g);
    $smarty->assign('nav', $nav);
}


include(ROOT.'view/front/header.html'); 
$smarty->display('smarty_shangpin.html', $goods_id);
include(ROOT . 'view/front/footer.html'); 

//include(ROOT . 'view/front/shangpin.html');
?>