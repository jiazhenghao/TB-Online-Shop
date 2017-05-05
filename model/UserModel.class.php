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
为增加商品写一个GoodsModel类，继承自Model
***/
class UserModel extends Model {
    protected $table = 'user';
    protected $pk = 'user_id';
    protected $field = array('user_id','username','email','passwd','regtime','lastlogin');
    protected $_valid = array(
                            array('username',1,'用户名必须存在','required'),
                            array('username',0,'用户名必须在4-16字符内','length','4,16'),
                            array('email',1,'email非法','email'),
                            array('passwd',1,'passwd不能为空','required')
    );
    protected $auto = array(
                            array('regtime','function','time')
    );
    
    //新的上传数据库方法，里面有了加密操作
    public function reg($data) {
        if($data['passwd']) {
            $data['passwd'] = $this->encPasswd($data['passwd']);
        }
        return $this->add($data);
    }
    
    //对编码进行加密
    protected function encPasswd($p) {
        return md5($p);
    }

    /*
    根据用户名查询用户信息
    */
    public function checkUser($username,$password='') {
        if ($password == '') {
            $sql = 'select count(*) from ' . $this->table . " where username='" .$username . "'";
            return $this->db->getOne($sql);
        }
        else {
            $sql = "select user_id,username,email,passwd from " . $this->table . " where username= '" . $username . "'";

            $row = $this->db->getRow($sql);

            if(empty($row)) {
                return false;
            }

            if($row['passwd'] != $this->encPasswd($password)) {
                return false;
            }

            unset($row['passwd']);
            return $row;
        }
        
    }    
}

?>