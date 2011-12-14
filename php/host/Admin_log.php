<?xml version = "1.0" encoding = "utf-8" encoding="utf-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns = "http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>餐饮信息查询系统</title>
<style>
body {
	background-image:url(../../image/Admin_log_p_back.jpg);
	text-align:center;
	font-size:24px;
}
a
{
	text-decoration:none;
}
a:visited
{
	color:#00F;
}
table {
	text-align:center;
	margin-left:auto;
	margin-right:auto;
}
</style>
</head>
<body>
<?php 
	error_reporting(E_ALL & ~ E_NOTICE);
	//连接数据库，并确定database
	$db = mysql_connect("", "se","se");
	mysql_select_db('meal',$db);
	//收集数据
	$useername=$_POST['useername'];
	$password=$_POST['password'];
    $query='select * from admin where name=\"'.$useername.'\"and pass=\"'.$password.'\"';
	$query=stripslashes($query);
	$result=mysql_query($query);
	$num=mysql_num_rows($result);
	$test=$_POST['test'];
	if($test!="true")
	{
		if($num==0)
			echo "<script>window.alert(\"用户名或密码错误\");window.location='../../Admin/Admin_log.html';</script>";
		else
			echo "<div style=\"text-align:right; margin-right:50px; color:#606\">你好，".$useername."!</div>";
	}
?>
<div style="padding:25px">
    <h1 style=" filter:glow(color=#FF0,strength=5);font-size:38px; font-family:STXinwei,STXingkai,SimHei;">北京大学餐饮信息查询系统</h1>
    </div>
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















