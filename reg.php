<?php 
header('Content-type: text/html; charset=UTF8'); 
date_default_timezone_set('Asia/Shanghai');

//允许访问的文件都必须要有常量ACC
define("ACC",true);
//所有用户直接访问的页面，必须先加载init.php
require("include/init.php");

/**
file reg.php
功能: 展示注册表单
**/
include(ROOT . '/view/front/zhuce.html');

?>