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
              <li class="active"><a href="./index.php"><i class="icon-home"></i> 首页</a></li>
              <li><a href="./about.php"><i class="icon-question-sign"></i> 关于</a></li>
              <li><a href="./contact.php"><i class="icon-envelope"></i> 联系我们</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container">

      <form class="form-signin" name="login" method="post" action="index.php">
        <h4 class="form-signin-heading">欢迎登录</h4>
        <input id="name" name="name" type="text" class="input-block-level" placeholder="用户名">
        <input id="pwd" name="pwd" type="password" class="input-block-level" placeholder="密码">
        <label class="checkbox">
          <input name="remember" type="checkbox" value="remember-me"> 记住我 
        </label>
        <span onclick="checkSubmit()" class="btn btn-middle btn-primary">登录</span>
        <label id="info" style="display:none" class="label label-important">密码错误</label>
        <div class="extra-block">
        <a href="register.php">注册用户</a> 或 
        <a href="contact.php">找回密码</a>
        </div>

      </form>

    </div> <!-- /container -->


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
    function checkSubmit() {
        var name=$("#name").val();
        var pwd=$("#pwd").val();
        name=name.replace(/\s/g, '');
        name=name.toLowerCase();
        name=name.replace(/[^0-9a-z\u4E00-\u9FA5]/g,'');
        $("#name").val(name);
        if (name=="") {
            $("#info").css('display','inline');
            $("#info").html('用户名为空');
        }

        var target="action/checklogin_do.php";
        var req="name="+name+"&pwd="+pwd;
        var callback=function() {
            if (xmlhttp.readyState==4 && xmlhttp.status==200) {
                var resp=xmlhttp.responseText;
                resp=$.trim(resp);
                if (resp == "nouser") {
                    $("#info").css('display','inline');
                    $("#info").html('用户不存在');
                } else if (resp == "fail") {
                    $("#info").css('display', 'inline');
                    $("#info").html('密码错误!');
                } else if (resp == "success") {
                    $("#info").css('display','none');
                    document.login.submit();
                }
            }
        }
        xmlhttp_req(target,req,callback);
    }
    </script>

  </body>
</html>
        
