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

$_POST['goods_weight'] = $_POST['goods_weight'] * $_POST['weight_unit'];
$data = array();
$goods = new GoodsModel();
$data = $goods->_facade($_POST);//先过滤一把
$data = $goods->_autoFill($data);//再自动填充没有的

//自动商品货号
if (empty($data['goods_sn'])) {
    $data['goods_sn'] = $goods->createSn();
}

//print_r($data);

if (!$goods->_validate($data)) {
    echo "没通过检验  数据不合法<br>";
    echo implode(',',$goods->getErr());
}
//上传图片
$up = new UpTool();
$ori_img = $up->upLoad('ori_img');
if ($ori_img) {
    $data['ori_img'] = $ori_img;
}
//如果$ori_img上传成功，就生成中等大小的缩略图
//再次生成更小的缩略图
//根据原始地址定缩略地址
//例如：a.jpg->thumb_a.jpg->goods_a.jpg
$ori_img = ROOT.$ori_img;
$thumb_img = dirname($ori_img).'/thumb_'.basename($ori_img);
if(ImageTool::thumb($ori_img, $thumb_img, $width=160, $height=220)) {
    $data['thumb_img'] = str_replace(ROOT,'',$thumb_img);
}
else {
    echo "thumb_img失败";
}
$goods_img = dirname($ori_img).'/goods_'.basename($ori_img);
if (ImageTool::thumb($ori_img, $goods_img, $width=300, $height=400)) {
    $data['goods_img'] = str_replace(ROOT,'', $goods_img);
} 
else {
    echo "goods_img失败";
}





if ($goods->add($data)) {
    echo "商品发布成功";
}
else {
    echo "商品发布失败";
}


?>