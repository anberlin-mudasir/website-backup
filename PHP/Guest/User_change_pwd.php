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
<?php include('common_userinfo.php'); ?>
<?php
	error_reporting(E_ALL & ~ E_NOTICE);
	//连接数据库，并确定database
	$db = mysql_connect("", "se","se");
	mysql_select_db('meal',$db);
	$query='select * from user where name=\"'.$useername.'\"';
	$query=stripslashes($query);
	$result=mysql_query($query);
	$num=mysql_num_rows($result);
	if($num==0)
		echo "<script>window.alert(\"请先登录\");window.location='../../Admin/Admin_log.html';</script>";
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
    <div class="feedList">
      <div class="section">
        <div id="cont-reg" class="block login-form">
          <div class="pop-win-inner">
            <form id="contents" name="contents" method="post" action="./User_change_pwd_result.php">
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
        <form name="search" action="./User_search.php" method="post">
        <?php include('common_post.php');?>
        </form>
        <span class="item itoolsBox">
          <a class="B" href="javascript:document.search.submit()">查找菜肴</a>
        </span>
      </p>
<?php
if ($useername!='guest')
{
?>
      <p>
        <form name="mark" action="./User_showmark.php" method="post">
        <?php include('common_post.php');?>
        </form>
        <span class="item itoolsFavorite">
          <a class="B" href="javascript:document.mark.submit()">查看收藏</a>
        </span>
      </p>
<?php
}
?>

      <p>
        <form name="back" action="./User_log.php" method="post">
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
