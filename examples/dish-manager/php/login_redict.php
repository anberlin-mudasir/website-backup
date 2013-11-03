<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns = "http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
    $query='select * from admin where name=\"'.$useername.'\" and pass=\"'.$password.'\"';
	$query=stripslashes($query);
    $result=mysql_query($query);
    $num=mysql_num_rows($result);
    if ($num!=0) // 登录者有管理员身份
    {
        echo "正在转向管理员界面...";
        echo "<form action='admin/Admin_log.php' method='post' name='frm'>";
        echo "<input type='hidden' name='test' value='true'/>";
    }
    else
    {
        echo "正在转向用户界面...";
        echo "<form action='guest/User_log.php' method='post' name='frm'>";
        echo "<input type='hidden' name='test' value='false'/>";
    }

// Here pass all post values to redicted pages
    foreach ($_POST as $a => $b) {
        echo "<input type='hidden' name='".$a."' value='".$b."'/>";
    }
    echo "</form>";
    echo "<script type=\"text/javascript\">";
    echo "document.frm.submit();";
    echo "</script>";
?>
</body>
</html>
