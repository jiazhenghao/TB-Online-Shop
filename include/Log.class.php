<?php 
/****
布尔教育 高端PHP培训
培  训: http://www.itbool.com
论  坛: http://www.zixue.it
****/
header('Content-type: text/html; charset=UTF8'); 
date_default_timezone_set('Asia/Shanghai');

defined("ACC") || exit("暗戳戳的不要访问");
/***
作用：记录信息到日志
思路：
给定内容，写入文件（fopen fwrite）
如果文件大于1M，重新写一份

传给我一个内容
	判断当前日志的大小
		如果大于1M，备份
		否则 写入
***/
class Log {
	const LOGFILE = "current.log";//建一个常量，代表日志文件的名称

	//写日志
	public static function write($content) {
		$content .= "\r\n";
		//判断是否备份
		$log = self::isBackup();
		$fh = fopen($log, "ab");
		fwrite($fh, $content);
		fclose($fh);
	}
	//备份日志
	public static function backup() {
		//就是把原来的日志文件，改个名，存储起来
		//改成年、月、日.bak这种形式
		$log = ROOT."data/log/".self::LOGFILE;
		$bak = ROOT."data/log/".date("Ymd His").".bak";
		return rename($log, $bak);
	}
	//读取日志的大小，返回M为单位
	public static function isBackup() {
		$log = ROOT."data/log/".self::LOGFILE;
		if(!file_exists($log)) {
			touch($log);//如果文件不存在，则创建该文件
			return $log;
		}
		//清除缓存，解决bug
		clearstatcache(true, $log);
		$size = filesize($log);
		if ($size > 1024 * 1024) {
			//需要备份了
			if (!self::backup()) {
				return $log;//备份失败，那就原来的文件里面写写吧
			}
			else {
				touch($log);//备份成功，那么就再次创建current.log这个文件
				return $log;
			}
		}
		else {
			return $log;
		}
	}
}


?>