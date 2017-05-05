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
require("include/init.php");

$up = new UpTool();
$up->setExt('jpg,jpeg,gif,bmp,png,rar,csv,sql');


if ($up->upLoad("pic")) {
    echo "<br>文件上传成功<br>";
}
else {
    echo '<br>文件上传失败<br>';
    echo $up->getErr();
}

?>