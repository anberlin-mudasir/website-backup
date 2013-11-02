<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Neo4You</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/customize.css" rel="stylesheet">
    <link href="css/bootstrap-responsive.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

  </head>

  <body>

    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="./index.php"><strong>Neo4You</strong></a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li><a href="./index.php"><i class="icon-home"></i> 首页</a></li>
              <li><a href="./about.php"><i class="icon-question-sign"></i> 关于</a></li>
              <li><a href="./contact.php"><i class="icon-envelope"></i> 联系我们</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container">
      <div class="center">
      <div class="well signup-twoside clearfix">
      <div class="signup-left">
      <form id="form" class="form-horizontal">
        <fieldset>
          <legend>用户注册</legend>

          <div id="name-group" class="control-group">
            <label class="control-label" for="name">用户名</label>
            <div class="controls">
              <input id="name" class="input" type="text" placeholder="请输入用户名，勿含空格" maxlength="10" onblur="checkUser(this)">
              <span id="name-succeed" class="help-inline"><i class="icon-ok icon-misc"></i></span>
              <span id="name-fail" class="help-inline"><i class="icon-remove icon-misc"></i></span>
              <span id="name-info" class="help-inline"></span>
            </div>
          </div>
          <div id="pwd-group" class="control-group">
            <label class="control-label" for="pwd">密码</label>
            <div class="controls">
              <input id="pwd" type="password" maxlength="10" onblur="checkPwd()">
              <span id="pwd-succeed" class="help-inline"><i class="icon-ok icon-misc"></i></span>
              <span id="pwd-fail" class="help-inline"><i class="icon-remove icon-misc"></i></span>
              <span id="pwd-info" class="help-inline"></span>
            </div>
          </div>
          <div id="rpwd-group" class="control-group">
            <label class="control-label" for="rpwd">重复密码</label>
            <div class="controls">
              <input id="rpwd" type="password" maxlength="10" onblur="checkPwd()">
              <span id="rpwd-succeed" class="help-inline"><i class="icon-ok icon-misc"></i></span>
              <span id="rpwd-fail" class="help-inline"><i class="icon-remove icon-misc"></i></span>
              <span id="rpwd-info" class="help-inline"></span>
            </div>
          </div>
          <div class="form-actions">
            <span href="#" class="btn btn-primary" onclick="javascript:checkSubmit()">提交</span>
            <button type="reset" class="btn">取消</button>
          </div>
        </fieldset>
      </form>
      </div> <!-- /well -->
      <div class="alert signup-right">
        请注意：
        <ul>
        <li>推荐使用英文字符作为用户名，</li>
        <li>键盘大小写将影响到密码的正确性；</li>
        <li>请在注册成功后向我们提供您的邮箱信息，方便您需要时找回密码。</li>
        </ul>
      </div>
      </div> <!-- /twoside -->
      </div> <!-- /center -->
    </div> <!-- /container -->
    
    <form id="hidden" name="hidden" method="post" action="index.php">
        <input type="text" name="name" value=""/>
        <input type="password" name="pwd" value=""/>
    </form>

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <!--script src="js/bootstrap.js"></script-->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap-transition.js"></script>
    <script src="js/bootstrap-alert.js"></script>
    <script src="js/bootstrap-modal.js"></script>
    <script src="js/bootstrap-dropdown.js"></script>
    <script src="js/bootstrap-scrollspy.js"></script>
    <script src="js/bootstrap-tab.js"></script>
    <script src="js/bootstrap-tooltip.js"></script>
    <script src="js/bootstrap-popover.js"></script>
    <script src="js/bootstrap-button.js"></script>
    <script src="js/bootstrap-collapse.js"></script>
    <script src="js/bootstrap-carousel.js"></script>
    <script src="js/bootstrap-typeahead.js"></script>
    <script src="js/xmlhttp.js"></script>
    <script type="text/javascript"> 
    function checkPwd() {
        var pwd=$("#pwd").val();
        var rpwd=$("#rpwd").val();
        if (pwd == "") {
            $("#rpwd-group").removeClass("success");
            $("#rpwd-succeed").css('display','none');
            $("#rpwd-fail").css('display','none');
            $("#rpwd-info").css('display','none');
            $("#pwd-group").removeClass("success");
            $("#pwd-group").addClass("error");
            $("#pwd-succeed").css('display','none');
            $("#pwd-fail").css('display','inline');
            $("#pwd-info").css('display','inline');
            $("#pwd-info").html('密码不能为空');
            return false;
        } else if (pwd != rpwd && rpwd != "") {
            $("#rpwd-group").removeClass("success");
            $("#rpwd-group").addClass("error");
            $("#rpwd-succeed").css('display','none');
            $("#rpwd-fail").css('display','inline');
            $("#rpwd-info").css('display','inline');
            $("#pwd-group").removeClass("success");
            $("#pwd-succeed").css('display','none');
            $("#pwd-fail").css('display','none');
            $("#pwd-info").css('display','none');
            $("#pwd-group").addClass("error");
            $("#rpwd-info").html('密码不相同');
            return false;
        } else if (pwd == rpwd){
            $("#pwd-group").removeClass("error");
            $("#pwd-group").addClass("success");
            $("#pwd-succeed").css('display','inline');
            $("#pwd-fail").css('display','none');
            $("#pwd-info").css('display','none');
            $("#rpwd-group").removeClass("error");
            $("#rpwd-group").addClass("success");
            $("#rpwd-succeed").css('display','inline');
            $("#rpwd-fail").css('display','none');
            $("#rpwd-info").css('display','none');
            return true;
        }
    }
    function checkUser() {
        var name=$("#name").val();
        name=name.replace(/\s/g, '');
        name=name.toLowerCase();
        name=name.replace(/[^0-9a-z\u4E00-\u9FA5]/g,'');
        $("#name").val(name);
        if (name=="") {
            $("#name-group").removeClass("success");
            $("#name-group").addClass("error");
            $("#name-succeed").css('display','none');
            $("#name-fail").css('display','inline');
            $("#name-info").css('display','inline');
            $("#name-info").html('用户名不能为空');
        } else {
            $("#name-group").removeClass("error");
            $("#name-fail").css('display','none');
            $("#name-info").css('display','none');
            testUser();
        }
    }
    function testUser() {
        var name=$("#name").val();
        var target="action/register_do.php";
        var req="name="+name;
        var callback=function() {
            if (xmlhttp.readyState==4 && xmlhttp.status==200) {
                var resp=xmlhttp.responseText;
                resp=$.trim(resp);
                if (resp != "nouser") {
                    $("#name-group").removeClass("success");
                    $("#name-group").addClass("error");
                    $("#name-info").html('用户已注册');
                    $("#name-succeed").css('display','none');
                    $("#name-fail").css('display','inline');
                    $("#name-info").css('display','inline');
                } else {
                    $("#name-group").removeClass("error");
                    $("#name-group").addClass("success");
                    $("#name-succeed").css('display','inline');
                    $("#name-fail").css('display','none');
                    $("#name-info").css('display','none');
                }
            }
        }
        xmlhttp_req(target,req,callback);
    }
    function checkSubmit() {
        if (checkPwd() == false)
            return;
        var name=$("#name").val();
        var pwd=$("#pwd").val();
        var target="action/register_do.php";
        var req="name="+name+"&pwd="+pwd;
        var callback=function() {
            if (xmlhttp.readyState==4 && xmlhttp.status==200) {
                var resp=xmlhttp.responseText;
                resp=$.trim(resp);
                if (resp == "exist") {
                    $("#name-group").removeClass("success");
                    $("#name-group").addClass("error");
                    $("#name-info").html('用户已注册');
                    $("#name-succeed").css('display','none');
                    $("#name-fail").css('display','inline');
                    $("#name-info").css('display','inline');
                } else if (resp == "fail") {
                    $("#reg-info").css('display', 'inline');
                    $("#reg-info").html('注册失败!');
                } else if (resp == "success") {
                    document.hidden.name.value=$("#name").val();
                    document.hidden.pwd.value=$("#pwd").val();
                    document.hidden.submit();
                }
            }
        }
        xmlhttp_req(target,req,callback);
    }
  </script>

  </body>
</html>
