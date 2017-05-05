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

include(ROOT."view/admin/templates/index.html");

 
?>