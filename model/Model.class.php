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
写一个Model类，是所有类的父类
***/
class Model {
	protected $table = NULL;//model所控制的表
	protected $db = NULL;// 引入的MySQL对象
    protected $pk = '';//保存主键值
    protected $field = array();//存放数据库中表的 每一列 名字 的数组
    protected $auto = array();//需要自动填充的列
    protected $_valid = array();//验证规则
    protected $error = array();//当自动验证出错时，显示此数组中的字符串
    
	public function __construct() {
		$this->db = MySQL::getIns();
	}

	public function table($table) {
		$this->table = $table;
	}
    
    //增
    public function add($data) {
		return $this->db->autoExecute($data,$this->table,"insert");
	}

    //删   根据主键，删除栏目
    public function delete($cat_id = 0) {
        $sql = "delete from ".$this->table." where ".$this->pk." = ".$cat_id;
        if ($this->db->query($sql)) {
            return $this->db->affected_rows();
        }
        else {
            return false;
        }    
    }
    
    //改  
    public function update($data, $id) {
        $rs = $this->db->autoExecute($data,$this->table,"update", " where ".$this->pk.' = '.$id);
        if ($rs) {
            return $this->db->affected_rows();
        }
        else {
            return false;
        }   
    }
    
    //查
    public function select() {
        $sql = "select * from ".$this->table;
        return $this->db->getAll($sql);
    }

    //查一行数据 
    public function find($id) {
        $sql = "select * from ".$this->table." where ".$this->pk.' = '.$id; 
        return $this->db->getRow($sql);
    }

    //负责把传来的数组清除掉table里不用的单元，留下与表对应的单元
    //自动过滤
    public function _facade($array) {
        //循环数组，分别判断其$key是否是表的字段，表的字段必须先设置好
        //表的字段可以用desc 表名  来分析
        //也可以手动写好，以tp为例  两者都行
        $data = array();
        foreach($array as $k=>$v) {
            if (in_array($k, $this->field)) {
                $data[$k] = $v; 
            }
        }
        return $data;
    }
    
    //自动填充
    public function _autoFill($array) {
        foreach ($this->auto as $k=>$v) {
            if(!array_key_exists($v[0], $array)) {
                switch ($v[1]) {
                    case 'value':$array[$v[0]] = $v[2];break;
                    case 'function':$array[$v[0]] = call_user_func($v[2]);break;
                }              
            }
        }
        return $array;
    }
    
    /*
        自动验证
        格式$this->_valid = array(
            array('验证的字段名', 0/1/2(场景名),'报错提示', 'require/in/between/length'),
        );
            protected $_valid = array(
            array('goods_name',1,'必须填写商品名','required'),
            array('cat_id',1,'必须是整型值','number'),
            array('is_new',0,'只能是0或1','in','0,1'),
            array('goods_brief',2,'应在10到100字符之间'，'length','10,100')          
        );
    */
    public function _validate($data) {
        $this->error = array();
        if (empty($this->_valid)) {
            return true;
        }
        foreach ($this->_valid as $k=>$v) {
            switch ($v[1]) {
                case 1: //必须要有这个字段，且不能为空
                    if (!isset($data[$v[0]]) || empty($data[$v[0]]) ) {
                        $this->error[] = $v[2];
                        return false;
                    }
                    if(!isset($v[4])) {
                        $v[4] = '';
                    }
                    if (!$this->check($data[$v[0]], $v[3], $v[4])) {//这里要继续 检测 规则
                        $this->error[] = $v[2];
                        return false;
                    }
                    break;           
                case 0://如果有这个字段，就需要检查，没有就算了，通过
                    if (isset($data[$v[0]])) {//老师写错了
                        if (!$this->check($data[$v[0]], $v[3], $v[4])) {
                            $this->error[] = $v[2];
                            return false;
                        }
                    }
                    break;
                case 2://如果有这个字段，且非空
                    if (isset($data[$v[0]]) && !empty($data[$v[0]])) {
                        if (!$this->check($data[$v[0]], $v[3], $v[4])) {
                            $this->error[] = $v[2];
                            return false;
                        }
                    }
                    break;
            }       
        }
        return true;
    }
    //辅助上面一个函数的受保护的函数
    protected function check($value, $rule, $parm) {
        switch ($rule) {
            case 'number':
                return is_numeric($value);
                break;
            case 'required' :     
                return !empty($value); 
                break;
            case 'in':  
                $tmp = explode(',', $parm);
                return in_array($value, $tmp);
                break;
            case 'between':
                list($min,$max) = explode(',', $parm);
                return $value >= $min && $value <= $max;
                break;
            case 'length':
                list($min,$max) = explode(',', $parm);
                return strlen($value) >= $min && strlen($value) <= $max;
                break;
            case 'email':
                //判断$value是否是email，可以用正则表达式
                //用系统函数来判断
                return (filter_var($value,FILTER_VALIDATE_EMAIL) !== false);
            default:
                return false;
        }
    }
    //打印错误信息
    public function getErr() {
        return $this->error;
    }

    public function insert_id() {
        return $this->db->insert_id();
    }

}

?>