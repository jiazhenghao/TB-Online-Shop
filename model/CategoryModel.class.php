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
CategoryModel类
对应cateaddAct.php里的表单
***/
class CategoryModel extends Model {
	protected $table = "category";
    //增
    public function add($data) {
		return $this->db->autoExecute($data,$this->table,"insert");
	}
    //删除栏目
    public function delete($cat_id = 0) {
        $sql = "delete from ".$this->table." where cat_id = ".$cat_id;
        $this->db->query($sql);
        return $this->db->affected_rows();
    }
    //改
    public function update($data, $where) {
        $this->db->autoExecute($data,$this->table,"update",$where);
        return $this->db->affected_rows();
    }
    //根据主键取出一行数据
    public function find($cat_id) {
        $sql = "select * from ".$this->table." where cat_id = ".$cat_id;
        return $this->db->getRow($sql);
    }
    //获取本表下面所有的数据
    public function select() {
        $sql = "select cat_id, cat_name, intro,parent_id from ".$this->table;
        return $this->db->getAll($sql);
    }
    
    //返回$id栏目的子孙树
    public function getCatTree($arr, $id = 0, $lev = 0) {
	    $subs = array();//子孙数组
	    foreach ($arr as $v) {
		    if ($v["parent_id"] == $id) {
			    $v["lev"] = $lev;
			    $subs[] = $v;
			    $subs = array_merge($subs, $this->getCatTree($arr,$v["cat_id"],$lev + 1));
		    }
	    }
	    return $subs;
    }
    //查找子栏目
    public function getSons($id) {
        $sql = "select cat_id, cat_name,parent_id from ".$this->table." where parent_id = ".$id;
        return $this->db->getAll($sql);
    }
    //查找家谱树  注意，千万不要用static递归，会在isInFather函数里导致隐藏逻辑bug
    public function getFather($arr, $id) {
        $tree = array();	
	    while ($id > 0) {  //当写成$id !== 0 时，会陷入死循环
		    foreach ($arr as $k => $v) {
			    if ($v["cat_id"] == $id) {
				    $tree[] = $v;
				    $id = $v["parent_id"];
				    break;
			    }	
		    }
	    }    
        return array_reverse($tree);
    }
    //判断一个给定$id的栏目，它的家谱树是否包含$cat_id的栏目
    public function isInFather($id, $cat_id) {
        $arr = $this->select();
        $tree = $this->getFather($arr,$id);
        print_r($tree);
        
        foreach($tree as $v) {
            if ($v["cat_id"] == $cat_id) {
                return true;
            }
        }
        return false;
    }
}
?>