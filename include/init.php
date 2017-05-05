<?php 
//这是一份初始化文件
header('Content-type: text/html; charset=UTF8'); 
date_default_timezone_set('Asia/Shanghai');

//设置报错级别
define("DEBUG", true);
if (defined("DEBUG")) {
	error_reporting(E_ALL & ~E_NOTICE);//调试时，尽量报错
}
else {
	error_reporting(0); //尽量少报错
}

//设置非法访问的屏蔽
defined("ACC") || exit("暗戳戳的不要访问");

//初始化当前的绝对路径
define("ROOT", str_replace("\\", "/", dirname(dirname(__FILE__))."/"));

//必须的加载项
require(ROOT."include/db.class.php");
require(ROOT."include/lib_base.php");
require(ROOT."include/mysmarty.class.php");//smarty引入

//自动加载
function __autoloadBool($class) {
    if(strtolower(substr($class,-5)) == 'model') {
        require(ROOT . 'Model/' . $class . '.class.php');
    } else if(strtolower(substr($class,-4)) == 'tool') {
        require(ROOT . 'tool/' . $class . '.class.php');
    } 
    else {
        require(ROOT . 'include/' . $class . '.class.php');
    }
}
spl_autoload_register("__autoloadBool");

//声明smarty变量
$smarty = new MySmarty();

//过滤参数 用递归的方法 $_GET, $_POST, $_COOKIE
$_GET = _addslashes($_GET);
$_POST = _addslashes($_POST);
$_COOKIE = _addslashes($_COOKIE);

//开启session
session_start();

?>