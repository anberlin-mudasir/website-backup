<?xml version = "1.0" encoding = "utf-8" encoding="utf-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns = "http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link href="../../css/base.css" type="text/css" rel="stylesheet"/>
  <link href="../../css/login.css" type="text/css" rel="stylesheet"/>
  <link href="../../css/user.css" type="text/css" rel="stylesheet"/>
  <link href="../../css/shop-min.css" type="text/css" rel="stylesheet"/>
  <title>用户注册</title>
  <script type="text/javascript">
	function checkSubmit(){
        var name;
        var pass;
        var pass2;
        document.contents.name.value=document.contents.name.value.replace(/^\s*|[\x00-\x1f]|\s*$/g, '')
        name=document.contents.name.value;
        pass=document.contents.password.value;
        pass2=document.contents.renewpassword.value;
        document.getElementById("pass-err-1").style.display='none';
        document.getElementById("pass-err-2").style.display='none';
        document.getElementById("name-err-1").style.display='none';
        document.getElementById("name-err-2").style.display='none';
        if (name=="")
        {
            document.getElementById("name-note").style.display='none';
            document.getElementById("name-err-2").style.display='block';
            return false;
        }
        document.getElementById("name-err-2").style.display='none';
        if (pass!=pass2)
        {
            document.getElementById("pass-err-1").style.display='block';
            return false;
        }
        else
        {
            document.getElementById("pass-err-1").style.display='none';
            if (pass=="")
            {
                document.getElementById("pass-err-2").style.display='block';
                return false;
            }
            document.getElementById("pass-err-2").style.display='none';

            var req="name="+name+"&pass="+pass;
            if (window.XMLHttpRequest)
            {// code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp=new XMLHttpRequest();
            }
            else
            {// code for IE6, IE5
                xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange=function() {
                if (xmlhttp.readyState==4 && xmlhttp.status==200)
                {
                    if (xmlhttp.responseText=="succeed")
                    {
                        document.getElementById("name-note").style.display='none';
                        document.getElementById("name-err-1").style.display='none';
                        document.redict.submit();
                    }
                    else
                    {
                        document.getElementById("name-note").style.display='none';
                        document.getElementById("name-err-1").style.display='block';
                        return false; 
                    }
                }
            }
            xmlhttp.open("POST","User_reg_do.php",true);
            xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xmlhttp.send(req);
        }
    }
  </script>
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
      <h3>用户注册</h3>
    </div>
    <div class="feedList">
      <div class="section">
        <div id="cont-reg" class="block login-form">
          <div class="pop-win-inner">
            <form id="contents" name="contents" method="post" action="#">
              <input name="test" class="Hide" type="text" value="false" />
              <div class="form-block">
                <label class="label" for="authuser">帐号：</label>
                <input name="name" id="authuser" class="form-default form-txt" type="text" placeholder="您的昵称，请勿含空格" />
                <span id="name-note" class="form-msg-box mb-note">要易记哦</span>
                <span id="name-err-1" class="form-msg-box mb-error" style="display:none">用户已存在!</span>
                <span id="name-err-2" class="form-msg-box mb-error" style="display:none">不能为空!</span>
              </div>
              <div class="form-block">
                <label class="label" for="authpassword">密码：</label>
                <input name="password" id="authpassword" class="form-default form-txt" type="password" />
              </div>
              <div class="form-block">
                <label class="label" for="reauthpassword">重复：</label>
                <input name="renewpassword" id="reauthpassword" class="form-default form-txt" type="password" />
                <span id="pass-err-1" class="form-msg-box mb-error" style="display:none">密码不一致</span>
                <span id="pass-err-2" class="form-msg-box mb-error" style="display:none">密码不能空</span>
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
        <span class="item itoolsStyle">
          <a class="B" href="../../index.html">返回首页</a>
        </span>
      </p>
      <p>
    </div>
  </div>
</div>
<form name="redict" method="post" action="User_reg_result.php">
    <input name="useername" class="Hide" type="text"/>
    <input name="test" class="Hide" type="text" value="false" />
</form>
</body>
</html>
