<?php
header('Content-type: text/html; charset=UTF8'); 
date_default_timezone_set('Asia/Shanghai');


define('ACC',true);
require('./include/init.php');


//include(ROOT . 'view/front/address.html');
include(ROOT . 'view/front/jiesuan.html');
//include(ROOT . 'view/front/order.html');
//include(ROOT . 'view/front/tijiao.html');

?>