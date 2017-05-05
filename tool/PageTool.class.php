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
====笔记部分====

分页类:

共5条商品,每页显示2条

问:共几页?
答:3页,页数是整的

问:第1页显示第几条到第几条?
答:1-2条

问:第2页显示第几条到第几条?
答:3-4条.



总结:

分页原理的3个变量!

总条数    $total
每页条数  $perpage
当前页    $page


分页原理的2个公式

总页数 $cnt = ceil($total/$perpage); // 相除,向上取整.


第$page页,显示第几条到第几条?
答: 第$page页,说明前面已经跳过$page-1页,每页又是$perpage条
跳过了($page-1)*$perpage条
,即从第($page-1)*$perpage+1 条开始取,取$perpage条出来



分页导航的生成
例:
c.php
c.php?cat_id=3
category.php?cat_id=3&page=1
c.php?page=1

分页导航里
[1] [2] 3 [4] [5]
page导航里,应根据页码来生成,但同时不能把其他参数搞丢,如cat_id


所以 我们先把地址栏的获取并保存起来
***/

class PageTool {
    protected $total = 0;
    protected $perpage = 10;
    protected $page = 9;

    public function __construct($total,$page=false,$perpage=false) {
        $this->total = $total;
        if($perpage) {
            $this->perpage = $perpage;
        }

        if($page) {
            $this->page = $page;
        }
    }
    
    // 主要函数,创建分页导航
    public function show() {
        $cnt = ceil($this->total/$this->perpage);  // 得到总页数
        $uri = $_SERVER['REQUEST_URI'];

        $parse = parse_url($uri);//解析 URL，返回其组成部分
        
        $param = array();
        if(isset($parse['query'])) {
            parse_str($parse['query'],$param);
        }

        // 不管$param数组里,有没有page单元,都unset一下,确保没有page单元,
        // 即保存除page之外的所有单元
        unset($param['page']);
        
        $url = $parse['path'] . '?';
        if(!empty($param)) {
            $param = http_build_query($param);//生成 URL-encode 之后的请求字符串
            $url = $url . $param . '&';
        }
        /*
        做了那么多，就是要在url里把page=xx 去除掉
        为什么要这么干呢，因为page是需要通过计算，自动生成的
        */

        
        // 下一个关键,就是计算页码导航
        $nav = array();
        $nav[0] = '<span class="page_now">' . $this->page . '</span>';
              
        for($left = $this->page-1,$right=$this->page+1;($left>=1||$right<=$cnt)&&count($nav) <= 5;) {
            
            if($left >= 1) {
                array_unshift($nav,'<a href="' . $url . 'page=' . $left . '">[' . $left . ']</a>');
                $left -= 1;
            }
            
            if($right <= $cnt) {
                array_push($nav,'<a href="' . $url . 'page=' . $right . '">[' . $right . ']</a>');
                $right += 1;
            }
        }  
        return implode('',$nav);

    }

}


?>