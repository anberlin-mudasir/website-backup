<?php
include('common/cookie.php');
if ($name=="" || $pwd=="") {
    $res="none";
    header("Location: login.php"); 
}
include('common/user.php');
$res = verify($name,$pwd);
$res = trim($res);
//echo $name."<br>".$pwd."<br>".$res;
?>


<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Neo4You</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
<?php
if (strcmp($res,"success")==0) {
    echo "<meta http-equiv='refresh' content='1;url=./main.php'>";
} else {
    echo "<meta http-equiv='refresh' content='1;url=./login.php'>";
}
?>

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
          <div id="dialog" class="modal hide fade">
            <div class="modal-header">
<?php
if (strcmp($res,'fail') == 0) {
    echo "<h3>登录信息不正确</h3>";
} else if (strcmp($res,'nouser')==0) {
    echo "<h3>无用户信息</h3>";
}
?>
            </div>
            <div class="modal-body">
              <p> 1秒后将转入首页，您也可以直接点击此链接<a href="login.php">重新登录</a>。</p>
            </div>
          </div>

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
<?php
if (strcmp($res,'fail') == 0 or strcmp($res, 'nouser') == 0 or strcmp($res, 'success')== 0) {
    echo "<script type='text/javascript'>$('#dialog').modal({backdrop:false,keyboard:false,show:true});</script>";
}
?>
  </body>
</html>
