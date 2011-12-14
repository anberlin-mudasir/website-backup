<?xml version = "1.0" encoding = "utf-8" encoding="utf-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns = "http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>修改菜肴</title>
  <link href="../../css/base.css" type="text/css" rel="stylesheet"/>
  <link href="../../css/login.css" type="text/css" rel="stylesheet"/>
  <link href="../../css/user.css" type="text/css" rel="stylesheet"/>
  <link href="../../css/shop-min.css" type="text/css" rel="stylesheet"/>
</head>
<body>
<?php include('common_admininfo.php'); ?>
<?php
	error_reporting(E_ALL & ~ E_NOTICE);
	//连接数据库，并确定database
	$db = mysql_connect("", "se","se");
    mysql_select_db('meal',$db);
    if (isset($_POST['status']))
        $status=$_POST['status'];
    else
        $status='';
	$query='select * from admin where name="'.$useername.'" and pass="'.$password.'"';
    $query=stripslashes($query);
	$result=mysql_query($query);
	$num=mysql_num_rows($result);
	if($num==0)
        echo "<script>window.alert(\"请先登录\");window.location='../../index.html';</script>";
?>
<?php include('header_admin.php'); ?>

<div class="main_w">
  <br />
  <div class="content_n">
    <div class="memberBox">
      <h3>修改菜肴</h3>
    </div>
    <div class="box feedBox">
<?php
if(strcmp($status,'succeed')==0 && isset($_POST['Number']))
{
    $Number=$_POST['Number'];
?>
      <div class="feedTip min-succeed"><p>修改成功!请查看<a href="javascript:document.lastdish.submit()">菜肴信息</a></p></div>
<?php
}
else
{
    $Number=0;
?>
      <div class="feedTip min-fail"><p>操作出错!请返回<a href="javascript:document.back.submit()">管理员面板</a></p></div>
<?php
}
?>
    </div>
  </div>
  <div class="asider_n">
    <div class="box tools">
        <span class="item itoolsStyle">
          <a class="B" href="javascript:document.back.submit()">管理页面</a>
        </span>
      </p>
    </div>
  </div>
</div>


<form class="Hide" name="back" action="./Admin_log.php" method="post">
<?php include('common_post.php');?>
</form>

<form class="Hide" name="lastdish" action="./Admin_show_dish.php" method="post">
<?php include('common_post.php');?>
<input type="hidden" name="Number" value="<?php echo $Number;?>"/>
</form>

</body>
</html>
