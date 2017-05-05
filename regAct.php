<?php 
header('Content-type: text/html; charset=UTF8'); 
date_default_timezone_set('Asia/Shanghai');
//允许访问的文件都必须要有常量ACC
define("ACC",true);
//所有用户直接访问的页面，必须先加载init.php
require("include/init.php");

/***
regAct.php
作用:接收用户注册的表单信息,完成注册
***/

$user = new UserModel();

/*
调用自动检验功能
检验用户名4-16字符之内
email检测
passwd不能为空
*/
if(!$user->_validate($_POST)) {  // 自动检验
    $msg = implode('<br />',$user->getErr());
    include(ROOT . 'view/front/msg.html');
    exit;
}

// 检验用户名是否已存在
if($user->checkUser($_POST['username'])) {
    $msg = '用户名已存在';
    include(ROOT . 'view/front/msg.html');
    exit;
}

$data = $user->_facade($_POST);//自动过滤
$data = $user->_autoFill($data);  // 自动填充

if($user->reg($data)) {
   $msg = '用户注册成功';
} else {
   $msg = '用户注册失败';
}

// 引入view
include(ROOT . 'view/front/msg.html');


?>