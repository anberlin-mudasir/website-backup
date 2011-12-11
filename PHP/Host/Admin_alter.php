<?xml version = "1.0" encoding = "utf-8" encoding="utf-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns = "http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gdb2312" />
<title>修改密码</title>
<style>
body {
	background-image:url(../../image/Admin_alter_pass_back.jpg);
	text-align:center;
	background-repeat:no-repeat;
}
h1 {
	filter:glow(color=#FF0,strength=5);
	font-size:38px; 
	font-family:STXinwei,STXingkai,SimHei;
	padding-top:50px;
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
	$useername=$_POST['user'];
	$query='select * from admin where name=\"'.$useername.'\"';
	$query=stripslashes($query);
	$result=mysql_query($query);
	$num=mysql_num_rows($result);
	if($num==0)
		echo "<script>window.alert(\"请先登录\");window.location='../../Admin/Admin_log.html';</script>";
	else
		echo "<div style=\"text-align:right; margin-right:50px; color:#FC0\">欢迎".$useername."</div>";
?>
<div>
    <h1>北京大学餐饮信息查询系统</h1>
    </div>
<div>
   <br />
   <br />
   <br />
   <br />
   <br />
   <br />
   </div>
<div>
<form action="./Admin_alter_pass.php" method="post">
<?php echo "<input type=\"hidden\" name=\"user\" value=\"".$useername."\" />";?>
<table>
<tr>
	<td><b>输入密码：</b></td>
	<td>
	<input type="password" name="newpass"/>
	</td>
</tr>
<tr>
	<td><b>确认密码：</b></td>
	<td>
    <input type="password" name="renewpassword" />
    </td>
</tr>
</table>
<p>
<br />
<input type="submit" value="确定" />
</p>
</form>
<form id="return" action="./Admin_log.php" method="post" style="color:#00F">
<input type="hidden" name="test" value="true" />
<?php
	echo "<input type=\"hidden\" name=\"uesername\" value=\"".$useername."\" />";
?>

<input type="hidden" name="password" value="" />
<p><div onclick="document.getElementById('return').submit()" style="cursor:hand;";>返回</div></p>
</form>
</div>
</body>
</html>
