<?php 
header('Content-type: text/html; charset=UTF8'); 
date_default_timezone_set('Asia/Shanghai');

//允许访问的文件都必须要有常量ACC
define("ACC",true);
//所有用户直接访问的页面，必须先加载init.php
require("include/init.php");

/***
用户登录页面
***/

if (isset($_POST['act'])) {
    //这说明是点击了登录按钮过来的
    //收用户名、密码
    $u = $_POST['username'];
    $p = $_POST['passwd'];
    // 合法性检测,自己做...

    $user = new UserModel();
    // 核对用户名,密码
    $row = $user->checkUser($u,$p);
    if(empty($row)) {
        $msg = '用户名密码不匹配!';
    } else {
        $msg = '登陆成功!';
        //session_start();
        $_SESSION = $row;

        if (isset($_POST['remember']))  {
            setcookie('remuser', $u, time()+14*24*3600);         
        }
        else {
            setcookie('remuser', '', 0);//注意这里要用空
        }
    }    
    include(ROOT . 'view/front/msg.html');
    exit;
}
else {
    $remuser = isset($_COOKIE['remuser']) ? $_COOKIE['remuser'] : '';
    //准备登录
    include(ROOT . '/view/front/denglu.html');
}

?>