<?xml version = "1.0" encoding = "utf-8" encoding="utf-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns = "http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link href="../../css/base.css" type="text/css" rel="stylesheet"/>
  <link href="../../css/login.css" type="text/css" rel="stylesheet"/>
  <link href="../../css/user.css" type="text/css" rel="stylesheet"/>
  <link href="../../css/shop-min.css" type="text/css" rel="stylesheet"/>
  <title>管理员界面</title>
</head>
<body>
<?php include("common_admininfo.php"); ?>
<?php 
	error_reporting(E_ALL & ~ E_NOTICE);
	$db = mysql_connect("", "se","se");
	mysql_select_db('meal',$db);
    $query='select * from admin where name=\"'.$useername.'\"and pass=\"'.$password.'\"';
	$query=stripslashes($query);
	$result=mysql_query($query);
	$num=mysql_num_rows($result);
	$test=$_POST['test'];
	if($test!="true")
	{
        if($num==0)
        {
            echo "<script>window.alert(\"用户名或密码错误\");window.location='../../index.html';</script>";
            die('');
        }

	}
?>
<?php include('header_admin.php'); ?>

<?php
$query = 'select * from dishes';
$result = mysql_query($query,$db);
$totalnum=mysql_num_rows($result);
$kai=$_POST['start'];
$limit=5;
if($kai<=0)
	$kai=0;
else
{
	if($kai>$totalnum-1)
	{
		if($totalnum%$limit!=0)
			$kai=$totalnum-$totalnum%$limit;
		else
			$kai=($totalnum==0)?$totalnum:$totalnum-5;
	}
}
$query = 'select * from dishes limit '.$kai.','. $limit;
$query=stripslashes($query);
$result = mysql_query($query,$db);
$num=mysql_num_rows($result);
?>

<div class="main_w">
  <br />
  <div class="content_n">
    <div class="memberBox">
      <h3>菜肴管理
<?php
if ($num!=0)
{
?>
        <div class="min-del-box">
          <a class="min-del" href="javascript:del('<?php echo $useername; ?>')">
            删除选中的菜肴</a>
        </div>
<?php
}
?>
      </h3>
    </div>
<?php
if ($num==0)
    echo '没有菜肴!';

while($row = mysql_fetch_assoc($result))
{
    extract($row);
?>
    <div class="feedList">
      <table class="min-table">
      <tr>
        <td rowspan="4">
        <form action="./Admin_showdish.php" method="post">
        <?php include('common_post.php');?>
<?php
    echo '<input width="249" type="image" height="168" alt="" src="../../image/'.$Url_of_image.'"/>';
	echo '<input type="hidden" name="Number" value="'.$Number.'"/>';
?>
        </form>
        </td>
        <td>
          <strong><?php echo $Name; ?></strong>
      </td>
      </tr>
      <tr><td><p>价格: 
        <span class="min-price">¥<?php echo $Price; ?></span></p></td></tr>
      <tr><td><p>评分: 
        <span class="min-score"> <?php echo round($Grade,2); ?> </span></p></td></tr>
      <tr><td>
        <div class="min-del-pick">
        <input type="checkbox" value="<?php echo $Number?>" name="deleteNumber[]"/>
         <span class="min-del">取消收藏</span>
        </div>
      </td></tr>
      </table>
    </div>
<?php
}
?>
<?php
if ($num!=0)
{
?>
    <div class="Pages">
<?php
$count_i=0;
$count_j=1;
$current=$kai/5+1;
$current0=($current-2)*$limit;
?>
<!--prev page -->
    <a class="PrevPage" title="上一页" href="javascript:document.pre.submit();">上一页</a>
    <form name="pre" class="Hide" action="#" method="post">
<?php
    echo '<input type="hidden" name="start" value="'.$current0.'"/>';
    include('common_post.php');
?>
    </form>
<!--num iteration -->
<?php
while($count_i<$totalnum)
{
    if($current!=$count_j)
        echo '<a class="PageLink" href="javascript:document.getElementById(\'page_'.$count_j.'\').submit();">'.$count_j.'</a>';
    else
        echo '<span class="PageSel" href="javascript:document.getElementById(\'page_'.$count_j.'\').submit();">'.$count_j.'</span>';
    echo '<form id="page_'.$count_j.'" class="Hide" action="#" method="post">';
    echo '<input type="hidden" name="start" value="'.$count_i.'"/>';
    include('common_post.php');
    echo '</form>';
    $count_j++;
    $count_i+=$limit;
}
?>


<!--next page -->
    <a class="NextPage" title="下一页" href="javascript:document.next.submit();">下一页</a>
    <form name="next" class="Hide" action="#" method="post">
<?php
    echo '<input type="hidden" name="start" value="'.($current*$limit).'"/>';
    include('common_post.php');
?>
    </form>
    </div> <!--div Pages-->
<?php
}
?>
  </div>

<!--  tool box -->
  <div class="asider_n">
    <div class="box tools">
      <p>
        <form name="back" action="./User_log.php" method="post">
        <?php include('common_post.php');?>
        </form>
        <span class="item itoolsStyle">
          <a class="B" href="javascript:document.back.submit()">返回主面板</a>
        </span>
      </p>
    </div>
  </div>
</div>



<form id="refresh" action="#" method="post"/>
  <input type="hidden" name="start" value="0" />
  <?php include('common_post.php');?>
</form>



<div>
<table>
<tr>
<td style="text-align:left;">请选择您所需的操作<br /><br /></td>
</tr>
<tr><td>
<?php
	echo "<form  id=\"add\" action=\"./dish.php\" method=\"post\" style=\"color:#00F\">";
	echo "<input type=\"hidden\" name=\"user\" value=\"".$useername."\" />";
	echo "<div onclick=\"document.getElementById('add').submit();\" style=\"cursor:hand;\"><p>添加菜肴<br /></p></div></form>";
?>
</td></tr>
<!--<tr><td>
<?php
	echo "<form  id=\"revise\" action=\"./updateDish.php\" method=\"post\" style=\"color:#00F\">";
	echo "<input type=\"hidden\" name=\"user\" value=\"".$useername."\" />";
	echo "<div onclick=\"document.getElementById('revise').submit();\" style=\"cursor:hand;\"><p>修改菜肴<br /></p></div></form>";
?>
</td></tr>-->
<tr><td>
<?php
	echo "<form  id=\"del\" action=\"./deleteDish.php\" method=\"post\" style=\"color:#00F\">";
	echo "<input type=\"hidden\" name=\"user\" value=\"".$useername."\" />";
	echo '<input type="hidden" name="start" value="0" />';
	echo "<div onclick=\"document.getElementById('del').submit();\" style=\"cursor:hand;\"><p>删改菜肴<br /></p></div></form>";
?>
</td></tr>
<tr><td>
<?php
	echo "<form  id=\"alter\" action=\"./Admin_alter.php\" method=\"post\" style=\"color:#00F\">";
	echo "<input type=\"hidden\" name=\"user\" value=\"".$useername."\" />";
	echo "<div onclick=\"document.getElementById('alter').submit();\" style=\"cursor:hand;\"><p>修改密码<br /></p></div></form>";
?>
</td></tr>
<tr><td><a href="../../index.html"><p>注销</p></a></td>


</table>
</div>
</body>
</html>
