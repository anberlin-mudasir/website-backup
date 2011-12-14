<?xml version = "1.0" encoding = "utf-8" encoding="utf-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns = "http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>修改密码</title>
  <link href="../../css/base.css" type="text/css" rel="stylesheet"/>
  <link href="../../css/login.css" type="text/css" rel="stylesheet"/>
  <link href="../../css/user.css" type="text/css" rel="stylesheet"/>
  <link href="../../css/shop-min.css" type="text/css" rel="stylesheet"/>
</head>
<body>
<?php include('common_userinfo.php'); ?>
<?php include('common_userinfo.php'); ?>
<?php
	error_reporting(E_ALL & ~ E_NOTICE);
	//连接数据库，并确定database
	$db = mysql_connect("", "se","se");
	mysql_select_db('meal',$db);
    $useername=$_POST['useername'];
    $password=$_POST['password'];
	$newpassword=$_POST['authpassword'];
	$renewpassword=$_POST['reauthpassword'];
	$query='select * from user where name="'.$useername.'" and pass="'.$password.'"';
    $query=stripslashes($query);
	$result=mysql_query($query);
	$num=mysql_num_rows($result);
	if($num==0)
        echo "<script>window.alert(\"请先登录\");window.location='../../index.html';</script>";
?>
<?php
    if ($useername!="guest")
        include('header_user.php');
    else
        include('header_guest.php');
?>


<div class="main_w">
  <br />
  <div class="content_n">
    <div class="memberBox">
      <h3>密码修改</h3>
    </div>
    <div class="box feedBox">
<?php
if(strcmp($newpassword,$renewpassword)==0)
{
    $query='update user set pass=\"'.$newpassword.'\" where name=\"'.$useername.'\"';
    $query=stripslashes($query);
    mysql_query($query);
    $password=$renewpassword; // important!
?>
      <div class="feedTip min-succeed"><p>修改成功!请返回<a href="javascript:document.back.submit()">用户面板</a></p></div>
<?php
}
else
{
?>
      <div class="feedTip min-fail"><p>修改失败!请返回<a href="javascript:document.change.submit()">修改页面</a></p></div>
<?php
}
?>
    </div>
  </div>
  <div class="asider_n">
    <div class="box tools">
      <p>
        <span class="item itoolsStyle">
          <a class="B" href="javascript:document.back.submit()">返回主页</a>
        </span>
      </p>
    </div>
  </div>
</div>


<form class="Hide" name="back" action="./User_log.php" method="post">
<?php include('common_post.php');?>
</form>
<form class="Hide" name="change" action="./User_change_pwd.php" method="post">
<?php include('common_post.php');?>
</form>






</body>
</html>
