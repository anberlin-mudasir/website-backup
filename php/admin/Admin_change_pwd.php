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
  <script type="text/javascript">
	function checkSubmit(){
        var name;
        var pass;
        var pass2;
        pass=document.contents.authpassword.value;
        pass2=document.contents.reauthpassword.value;
        document.getElementById("pass-err-1").style.display='none';
        document.getElementById("pass-err-2").style.display='none';
        if (pass!=pass2)
        {
            document.getElementById("pass-err-1").style.display='block';
            return false;
        }
        document.getElementById("pass-err-1").style.display='none';
        if (pass=="")
        {
            document.getElementById("pass-err-2").style.display='block';
            return false;
        }
        document.getElementById("pass-err-2").style.display='none';
        return true;
    }
  </script>
</head>
<body>
<?php include('common_admininfo.php'); ?>
<?php
	error_reporting(E_ALL & ~ E_NOTICE);
	$db = mysql_connect("", "se","se");
	mysql_select_db('meal',$db);
	$useername=$_POST['useername'];
	$password=$_POST['password'];
	$query='select * from admin where name="'.$useername.'" and pass="'.$password.'"';
	$query=stripslashes($query);
	$result=mysql_query($query);
	$num=mysql_num_rows($result);
    if($num==0)
    {
        echo "<script>window.alert(\"请先登录\");window.location='../../index.html';</script>";
        die('');
    }
?>
<?php include('header_admin.php');?>

<div class="main_w">
  <br />
  <div class="content_n">
    <div class="memberBox">
      <h3>密码修改</h3>
    </div>
    <div class="feedList">
      <div class="section">
        <div id="cont-reg" class="block login-form">
          <div class="pop-win-inner">
            <form id="contents" name="contents" method="post" action="./Admin_change_pwd_result.php">
            <?php include('common_post.php');?> 
              <div class="form-block">
                <label class="label" for="authpassword">新密码:</label>
                <input name="authpassword" id="authpassword" class="form-default form-txt" type="password" />
              </div>
              <div class="form-block">
                <label class="label" for="reauthpassword">请重复:</label>
                <input name="reauthpassword" id="reauthassword" class="form-default form-txt" type="password" />
                <span id="pass-err-1" class="form-msg-box mb-error" style="display:none">密码不一致</span>
                <span id="pass-err-2" class="form-msg-box mb-error" style="display:none">密码为空</span>
              </div>
              <div class="block form-btn-block form-block form-content-block">
                <span class="btn-type-b btn-fn-c">
                  <a class="form-btn" href="javascript:if(checkSubmit())document.getElementById('contents').submit()">确认</a>
                </span>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="asider_n">
    <div class="box tools">
      <p>
        <form name="add" action="./Admin_add_dish.php" method="post">
        <?php include('common_post.php');?>
        </form>
        <span class="item itoolsUpface">
          <a class="B" href="javascript:document.add.submit()">添加菜肴</a>
        </span>
      </p>
      <p>
        <form name="back" action="./Admin_log.php" method="post">
        <?php include('common_post.php');?>
        </form>
        <span class="item itoolsStyle">
          <a class="B" href="javascript:document.back.submit();">返回主面板</a>
        </span>
      </p>
      <p>
    </div>
  </div>
</div>
</body>
</html>
