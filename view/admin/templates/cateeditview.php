<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>ECSHOP 管理中心 - 添加分类 </title>
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../view/admin/styles/general.css" rel="stylesheet" type="text/css" />
<link href="../view/admin/styles/main.css" rel="stylesheet" type="text/css" />
</head>
<body>

<h1>
<span class="action-span"><a href="catelist.html">商品分类</a></span>
<span class="action-span1"><a href="#">ECSHOP 管理中心</a> </span><span id="search_id" class="action-span1"> - 添加分类 </span>
<div style="clear:both"></div>
</h1>

<div class="main-div">
  <form action="cateeditAct.php" method="post" name="theForm" enctype="multipart/form-data">
  <table width="100%" id="general-table">
      <tr>
        <td class="label">分类名称:</td>
        <td>
          <input type='text' name='cat_name' maxlength="20" value='<?php echo $catinfo["cat_name"];   ?>' size='27' /> <font color="red">*</font>
        </td>
      </tr>
      <tr>
        <td class="label">上级分类:</td>
        <td>
          <select name="parent_id">
                <option value="0">顶级分类</option>
                <?php  foreach($catlist as $v) {  if(!$cat->isInFather($v['cat_id'], $cat_id)) { ?> 
            	<option value="<?php echo $v['cat_id']; ?>"  <?php if ($v['cat_id'] == $catinfo['parent_id'] )  {echo "selected"; }   ?>  > 
            	<?php echo str_repeat("&nbsp&nbsp", $v["lev"]),$v["cat_name"]; ?> 
            	</option>                  
     		    <?php } } ?>                      
          </select>
        </td>
      </tr>
      <tr>
        <td class="label">栏目简介:</td>
        <td>
          <textarea name='intro' rows="6" cols="48"><?php echo $catinfo["intro"];   ?></textarea>
        </td>
      </tr>
      </table>

      <div class="button-div">
        <input type="submit" value=" 确定 " />
        <input type="reset" value=" 重置 " />
      </div>
    <input type="hidden" name="cat_id" value="<?php echo $catinfo['cat_id']   ?>" />
  </form>
</div>

<div id="footer">
共执行 3 个查询，用时 0.021687 秒，Gzip 已禁用，内存占用 2.081 MB<br />
版权所有 &copy; 2005-2010 上海商派网络科技有限公司，并保留所有权利。</div>

</body>
</html>