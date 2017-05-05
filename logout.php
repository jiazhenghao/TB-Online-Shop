<?php
header('Content-type: text/html; charset=UTF8'); 
date_default_timezone_set('Asia/Shanghai');


define('ACC',true);
require('./include/init.php');


//session_start();
session_destroy();


$msg = '退出成功';

include(ROOT . 'view/front/msg.html');


?>