<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns = "http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>上传文件</title>
  <link href="css/base.css" type="text/css" rel="stylesheet"/>
  <link href="css/login.css" type="text/css" rel="stylesheet"/>
  <link href="css/user.css" type="text/css" rel="stylesheet"/>
  <link href="css/shop-min.css" type="text/css" rel="stylesheet"/>
</head>
<body>
<?php
    if (isset($_POST['status']))
        $status=$_POST['status'];
    else
        $status='';
?>
<div class="main_w">
  <br />
  <div class="content_n">
    <div class="memberBox">
      <h3>上传文件</h3>
    </div>
    <div class="box feedBox">
<?php
if(strcmp($status,'succeed')==0)
{
?>
      <div class="feedTip min-succeed"><p>添加成功!请返回<a href="javascript:document.back.submit()">文件列表</a></p></div>
<?php
}
else if(strcmp($status,'file-large')==0)
{
?>
      <div class="feedTip min-fail"><p>文件太大!请返回<a href="javascript:document.add.submit()">上传界面</a></p></div>
<?php
}
else
{
?>
      <div class="feedTip min-fail"><p>操作失败!请返回<a href="javascript:document.add.submit()">上传界面</a></p></div>
<?php
}
?>
    </div>
  </div>
  <div class="asider_n">
    <div class="box tools">
      <p>
        <span class="item itoolsStyle">
          <a class="B" href="javascript:document.add.submit()">继续添加</a>
        </span>
      <p>
        <span class="item itoolsStyle">
          <a class="B" href="javascript:document.back.submit()">上传界面</a>
        </span>
      </p>
    </div>
  </div>
</div>
<form class="Hide" name="back" action="./incoming" method="post">
</form>
<form class="Hide" name="add" action="./index.php" method="post">
</form>
</body>
</html>
