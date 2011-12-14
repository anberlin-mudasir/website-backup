<?xml version = "1.0" encoding = "utf-8" encoding="utf-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns = "http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gdb2312" />
<title>登陆</title>
</head>
<body>
<?php
	error_reporting(E_ALL & ~ E_NOTICE);
	//连接数据库，并确定database
	$db = mysql_connect("", "se","se");
	mysql_select_db('meal',$db);
	$useername=$_POST['user'];
	$newpassword=$_POST['newpass'];
	$renewpassword=$_POST['renewpassword'];
	$query='select * from admin where name=\"'.$useername.'\"';
	$query=stripslashes($query);
	$result=mysql_query($query);
	$num=mysql_num_rows($result);
	if($num==0)
		echo "<script>window.alert(\"请先登录\");window.location='../../Admin/Admin_log.html';</script>";
	else
	{
		echo "<form  id=\"form1\" action=\"./Admin_alter.php\" method=\"post\">";
		echo "<input type=\"hidden\" name=\"user\" value=\"".$useername."\" /></form>";
		if(strcmp($newpassword,$renewpassword)!=0)
			echo "<script>window.alert(\"操作失败，请重新输入\");document.getElementById('form1').submit();</script>";
		else
		{
			$query='update admin set pass=\"'.$newpassword.'\" where name=\"'.$useername.'\"';
			$query=stripslashes($query);
			$result=mysql_query($query);
			echo "<form  id=\"form2\" action=\"./Admin_log.php\" method=\"post\">";
			echo "<input type=\"hidden\" name=\"test\" value=\"true\" />";
			echo "<input type=\"hidden\" name=\"useername\" value=\"".$useername."\" />";
			echo "<input type=\"hidden\" name=\"password\" value=\" \" />";
			echo "</form>";
			echo "<script>window.alert(\"修改成功\");document.getElementById('form2').submit();</script>";
		}
	}
?>
</body>
</html>
