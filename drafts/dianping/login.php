<html>
<head>
  <link href="css/base.css" type="text/css" rel="stylesheet"/>
  <link href="css/index.css" type="text/css" rel="stylesheet"/>
  <script type="text/javascript">
    function fixPos()
    {
       var width=400;
       var up=100;
       document.getElementById("pop").style.width=width+"px";
       document.getElementById("pop").style.left=(document.body.clientWidth-width)/2;
       document.getElementById("pop").style.top=up+"px";
    }
    window.onload=fixPos;
    window.onresize=fixPos;
    function autologin()
    {
        document.getElementById('authuser').value="guest";
        document.getElementById('authpassword').value="guest";
        document.loginform.submit();
    }
    function checkSubmit()
    {
        if (document.loginform.useername.value!="" && 
            document.loginform.password.value!="")    
            return true;
        else
            return false;
    }
  </script>
  <style type="text/css">
  body
  {
    background-image:url(css/peking.png);
    background-repeat:no-repeat;
    background-position:;
  }
  </style>
</head>
<body>
<div class="header-bar">
  <div class="inner Fix">
    <span class="tagline">北京大学餐饮信息查询系统欢迎您</span>
  </div>
</div>

<div id="pop" class="pop-win pop-login " style="width: 400px; left: 431px; top: 100px;">
  <div class="ele-wrap wrap" style="visibility: visible;">
    <div class="dialog-title">北京大学餐饮信息查询系统
      <span class="title-misc">用户登录 </span>
    </div>
  <div class="dialog-cont">
    <div class="pop-win-inner">
      <div class="form-block">
        <label class="label" for="authuser">帐号：</label>
        <input id="authuser" class="form-txt form-default" type="text" placeholder="" tabindex="1">
      </div>
      <div class="form-block">
        <label class="label" for="authpassword">密码：</label>
        <input id="authpassword" class="form-txt" type="password" tabindex="2">
      </div>
      <div class="form-btn-block">
        <span class="btn-type-b btn-fn-c">
          <a class="form-btn" tabindex="4" href="javascript:;">登录</a>
        </span>
      </div>
      <div class="pop-win-misc">
        <span class="note">
          <a href="#">注册用户</a>
        </span>
        或
        <span class="note">
          <a href="#">游客登录</a>
        </span>
      </div>
    </div>
  </div>
</div>

</body>
</html>
