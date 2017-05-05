<?php 
header('Content-type: text/html; charset=UTF8'); 
date_default_timezone_set('Asia/Shanghai');

defined("ACC") || exit("暗戳戳的不要访问");

require(ROOT.'lib/Smarty3/libs/Smarty.class.php');
class MySmarty extends Smarty {
    public function __construct() {
        parent::__construct();       
        $this->setTemplateDir(ROOT.'view/front');
        $this->setCompileDir(ROOT.'data/comp'); 
        $this->setCacheDir(ROOT.'data/cache');
        //$this->setConfigDir('./conf');
    }
}

?>