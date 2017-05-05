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
文件上传类
***/
class UpTool {
    protected $allow_ext = 'jpg,jpeg,gif,bmp,png';//限制后缀类型
    protected $max_size = 1;//最大1M
    protected $file = null;//储存上传文件的信息用的
    protected $errorNumber = 0;//错误代码
    protected $error = array(
        0=>'无错',
        1=>'上传文件超出系统限制',
        2=>'上传文件大小超出网页表单页面',
        3=>'文件只有部分被上传',
        4=>'没有文件被上传',
        6=>'找不到临时文件夹',
        7=>'文件写入失败',
        8=>'不允许的文件后缀',
        9=>'文件大小超出的类的允许范围',
        10=>'创建目录失败',
        11=>'移动失败'
        );//错误具体原因
    public function setExt($exts) {
        $this->allow_ext = $exts;
    }
    public function setSize($size) {
        $this->max_size = $size;
    }

    
    //给我一个文件名，帮你计算后缀
    protected function getExt($file) {
        $exts = explode('.', $file);
        return end($exts);
    }

    //是否允许这种后缀
    //还需要大小写
    protected function isAllowExt($ext) {
        $ext = strtolower($ext);
        return in_array($ext, explode(',' , $this->allow_ext));
    }

    //检查文件的大小
    protected function isAllowSize($size) {
        return $size <= $this->max_size * 1024 * 1024;
    }
    
    //按日期创建目录的方法
    protected function mk_dir() {
        $dir = ROOT.'data/images/'.date('Ym/d');
        if (is_dir($dir) || mkdir($dir, 0777, true)) {
            return $dir;
        }
        else {
            return false;
        }
    }

    //生成随机文件名
    protected function randName($length = 6) {
        $str = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        return substr(str_shuffle($str) , 0 , $length);
    }

    public function upLoad($key) {
        if (!isset($_FILES[$key])) {
            echo '文件全局数据$_FILES下未找到$key';
            return false;
        }
        $f = $_FILES[$key];
        //检查文件上传有没有成功
        if ($f['error']) {
            $this->errorNumber = $f['error'];
            return false;
        }

        //获取后缀
        $ext = $this->getExt($f['name']);
        //检查后缀
        if (!$this->isAllowExt($ext)) {            
            $this->errorNumber = 8;
            return false;
        }
        //检查大小
        if (!$this->isAllowSize($f['size'])) {           
            $this->errorNumber = 9;
            return false;
        }
        //通过了，开始创建目录
        $dir = $this->mk_dir();
        if ($dir == false) {       
            $this->errorNumber = 10;
            return false;
        }
        //生成随机文件名
        $newName = $this->randName().'.'.$ext;
        //移动
        if (!move_uploaded_file($f['tmp_name'], $dir.'/'.$newName)) {
            $this->errorNumber = 11;
            return false;
        }
        $dir = $dir.'/'.$newName;
        return str_replace(ROOT,'',$dir);//用空字符串替代掉ROOT，成为相对路径
    }
    public function getErr() {
        return $this->error[$this->errorNumber];
    }

}




?>