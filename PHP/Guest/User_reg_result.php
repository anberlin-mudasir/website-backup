<?xml version = "1.0" encoding = "utf-8" encoding="utf-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns = "http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link href="../../css/base.css" type="text/css" rel="stylesheet"/>
  <link href="../../css/user.css" type="text/css" rel="stylesheet"/>
  <link href="../../css/shop-min.css" type="text/css" rel="stylesheet"/>
  <link href="../../css/login.css" type="text/css" rel="stylesheet"/>
  <title>用户注册</title>
</head>


<body>
<div class="header-bar">
  <div class="inner Fix">
    <span class="tagline">北京大学餐饮信息查询系统欢迎您</span>
  </div>
</div>

<div class="main_w">
  <br />
  <div class="content_n">
    <div class="memberBox">
      <h3>用户注册
      </h3>
    </div>
    <div class="box feedBox">
<?php
if (isset($_POST['test']) && $_POST['test']=='false') 
{
?>
      <div class="feedTip min-succeed"><p>用户<strong>
<?php
    echo $_POST['useername'];
?>
      </strong>注册成功!请返回<a href="../../index.html">首页</a>并登录!</p>
      </div>
<?php
}
else
{
?>
      <div class="feedTip min-fail"><p>
      注册出错!请返回<a href="User_reg.php">注册页面</a></p>
      </div>
<?php
}
?>
    </div>
  </div>
  <div class="asider_n">
    <div class="box tools">
      <p>
        <span class="item itoolsStyle">
          <a class="B" href="../../index.html">返回首页</a>
        </span>
      </p>
    </div>
  </div>
</div>
</body>
</html>
