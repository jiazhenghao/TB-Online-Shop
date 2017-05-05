<?php
//商城首页
header('Content-type: text/html; charset=UTF8'); 
date_default_timezone_set('Asia/Shanghai');

define('ACC',true);
require('./include/init.php');

//取出5条新品
$goods = new GoodsModel();
$newlist = $goods->getNew(5);
//取出指定栏目的商品，未完成
//女士大栏目下的商品
$female_id = 4;
$felist = $goods->catGoods($female_id);
//男士大栏目下的商品，未完成
$smarty->assign('newlist', $newlist);
$smarty->assign('felist', $felist);



//include(ROOT.'view/front/header.html'); 
$smarty->display('index.html');
include(ROOT . 'view/front/footer.html'); 
//include(ROOT . 'view/front/index.html');
//要在105行echo mb_substr($g['goods_name'], 0, 12, 'UTF-8'),'...'; 就需要使用到变量调节器了 truncate:14:'...'
?>  