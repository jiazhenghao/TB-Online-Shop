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
class OIModel extends Model {
    protected $table = 'orderinfo';
    protected $pk = 'order_id';
    protected $field = array('order_id','order_sn','user_id','username','zone','address','zipcode','reciver','email','tel','mobile','building','best_time','add_time','order_amount','pay');

    protected $_valid = array(
                            array('reciver',1,'收货人不能为空','required'),
                            array('email',1,'email非法','email'),
                            array('pay',1,'必须先支付方式','in','4,5') //代表在线支付与到付.
    );

    protected $auto = array(
                            array('add_time','function','time')
                            );


    public function orderSn() {
        $sn = 'OI' . date('Ymd') . mt_rand(10000,99999);
        $sql = 'select count(*) from ' . $this->table  . ' where order_sn=' . "'$sn'";
        return $this->db->getOne($sql)?$this->orderSn():$sn;
    }


    public function invoke($order_id) {
        $this->delete($order_id); // 先删掉订单

        $sql = 'delete from ordergoods where order_id = ' . $order_id; // 再删订单对应的商品
        
        return $this->db->query($sql);
    }
}




?>