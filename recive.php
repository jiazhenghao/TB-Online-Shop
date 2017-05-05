<?php
header('Content-type: text/html; charset=UTF8'); 
date_default_timezone_set('Asia/Shanghai');

define('ACC',true);
require('./include/init.php');
//这是支付宝的服务器端发回的 回调地址，可以选择不让用户看到，这更安全一点。
//通过这个页面计算出一些结果，返回给让用户看到的页面，告知用户支付成功或者失败。
//这里为了简化，就不做这一步了



// 在线支付的返回信息接收页面


//拿来你这商户的秘钥
require(ROOT . './include/md5key.php');

// 计算出md5info
$md5info = md5($_POST['v_oid'] . $_POST['v_pstatus'] . $_POST['v_amount'] . $_POST['v_moneytype'] . $md5key);
$md5info = strtoupper($md5info);


// 再拿计算出的md5info和表单发来的md5info对比
if($md5info !== $_POST['v_md5str']) {
    echo '你想出老千!';
    exit;
}

//告诉网站管理员后台，这个订单已成功支付
echo '执行sql语句,把订单号',$_POST['v_oid'];
echo '对应的订单改为已支付';

//include(ROOT. 'view/front/xxxx.html');

?>