<?php
include('common/cookie.php');
if ($name=="" || $pwd=="") {
    $res="none";
    header("Location: login.php"); 
}
include('common/user.php');
if (trim(verify($name,$pwd)) != "success") {
    header("Location: index.php"); 
}

$oname="";
if (isset($_GET["name"])) {
    $oname=trim($_GET["name"]);
}
if (trim(existuser($oname)) != "exist") {
    header("Location: main.php");  // 可以加一个导航
    die();
}
if ($oname == $name) {
    header("Location: self.php");
}

include('common/identicon.php');
$identicon=new identicon;
$img_link=$identicon->identicon_build($name,'[alt]',false);
$oimg_link=$identicon->identicon_build($oname,'[alt]',false);

include('common/friend.php');
$watch = trim(isfriend($oname,$name,$pwd));
$num_friend =trim(fetch_friendnum($oname, $name, $pwd));
$num_rfriend=trim(fetch_reversefriendnum($oname, $name, $pwd));
$num_fields=0;
$friends=array();
$res=trim(fetch_friends($oname, $name, $pwd));
foreach(preg_split("/((\r?\n)|(\r\n?))/", $res) as $line){
    $friends[$num_fields] = $line;
    $num_fields++;
} 
if ($num_fields== 1 && $friends[0] == "fail")
    $num_fields= 0;

include('common/msg.php');
$res=trim(fetch_msg($oname, $name, $pwd));
$num_msg=0;
$msg=array();
foreach(preg_split("/((\r?\n)|(\r\n?))/", $res) as $line){
    $msg[$num_msg] = $line;
    $num_msg++;
} 
if ($num_msg == 1)
    $num_msg = 0;
?>


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
    <style>
        body {
            background-image:none;
        }
    </style>

  </head>

  <body data-spy="scroll" data-target=".subnav" data-offset="50">

    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="./index.php"><strong>Neo4You</strong></a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li><a href="./main.php"><i class="icon-home"></i> 首页</a></li>
              <li><a href="./self.php"><i class="icon-user"></i> 个人主页</a></li>
              <li class="active"><a href="#"><i class="icon-share"></i> 分享页面</a></li>
            </ul>
          </div>
            <ul class="nav pull-right">
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">帐号 <b class="caret"></b></a>
                <ul class="dropdown-menu">
                <li><a><img src="<?php echo $img_link ?>" class="img-polaroid usr"><?php echo $name ?> </a>
                  </li>
                  </li>
                  <li class="divider"></li>
                  <li><a href="#"><i class="icon-off"></i> 注销</a></li>
                </ul>
              </li>
            </ul>
            <form class="navbar-search pull-right">
              <input type="text" class="search-query" placeholder="搜索好友">
            </form>
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="row-fluid">
        <div class="span1"></div>
        <div class="span2 main-left">
                <table class="fixed">
                <col width="95px"/>
                <col width="60px"/>
                <col width="60px"/>
                <tr>
                <td rowspan="3"><img src="<?php echo $oimg_link ?>" class="img-polaroid usr"></td>
                <td colspan="2"><a href="?name=<?php echo $oname ?>"><strong><?php echo $oname; ?></strong></a></td>
                </tr>
                <tr><td><b><i class="icon-share"></i><small>关注</small></b></td>
                <td><b><i class="icon-eye-open"></i><small>粉丝</small></b></td></tr>
                <tr><td><?php echo $num_friend ?></td>
                <td><?php echo $num_rfriend ?></td></tr>
                </table>
<?php
    if ($watch != "true") {
?>
                <span onclick="javascript:setfriend('<?php echo $oname ?>')" data-loading-text="关注中" id="w<?php echo $oname ?>" class="btn btn-info fat-btn"><i class="icon-plus icon-white"></i> <strong>关注</strong></span>
                <span style="display:none" id="wd<?php echo $oname ?>" class="btn btn-success disabled"><i class="icon-ok icon-white"></i> <strong>已关注</strong> | <a href="javascript:delfriend('<?php echo $oname ?>')">取消关注</a></span>

<?php
    } else {
?>
                <span style="display:none" onclick="javascript:setfriend('<?php echo $oname ?>')" data-loading-text="关注中" id="w<?php echo $oname ?>" class="fat-btn btn btn-info"><i class="icon-plus icon-white"></i> <strong>关注</strong></span>
                <span id="wd<?php echo $oname ?>" class="btn btn-success disabled"><i class="icon-ok icon-white"></i> <strong>已关注</strong> | <a href="javascript:delfriend('<?php echo $oname ?>')">取消关注</a></span>

<?php
    }
?>

                <hr>

                <div class="well recommend">
                <strong><small>TA的关注</small></strong><br><br>
                <table><tr>

<?php
if ($num_friend == 0) {
    echo "TA很懒，谁都不关心";
}
for ($i=0; $i<$num_fields; $i+=2) {
    $tname=$friends[$i];
    $twatch=$friends[$i+1];
    $timg=$identicon->identicon_build($tname,'[alt]',false);
?>
    <td rowspan="2"><img src="<?php echo $timg ?>" class="img-polaroid recommend"></td><td><a href="./othr.php?name=<?php echo $tname ?>"><?php echo $tname ?></a></td>
                </tr><tr>
                <td>
<?php
    if ($twatch == "true") {
?>
                <a><span class="label label-success"  id="wd<?php echo $tname ?>">已关注</span></a>

<?php
    } else if ($tname != $name) {
?>
                <a href="javascript:setfriend('<?php echo $tname ?>')"><span data-loading-text="关注中" class="label label-info fat-btn" id="w<?php echo $tname ?>">+ 关注</span></a>
                <a><span class="label label-success" style="display:none" id="wd<?php echo $tname ?>">已关注</span></a>
<?php
    } else {
?>
                <a><span class="label label-success">TA关注了你</span></a>
<?php
    }
?>
                </td>
                </tr><tr>
                <td><br></td></tr><tr>
<?php
}
?>

                </tr></table>
                </div>
        </div>
        <div class="span6 main-middle">
            <br>
          <div class="accordion" id="accordion2">
<?php
for ($i=0; $i < $num_msg; $i+=2) {
    $tcontent=$msg[$i];
    if (mb_strlen($tcontent,'utf-8')>30)
        $ttitle=mb_substr($tcontent,0,30,'utf-8')."...";
    else
        $ttitle=$tcontent;
    $ttime=$msg[$i+1];
?>
            <div class="accordion-group">
              <div class="accordion-heading">
                <span class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse<?php echo $i ?>">
                <a data-original-title="<img src='<?php echo $oimg_link ?>'/>  <a href=''><?php echo $oname ?></a>" href="#" class="popover-test" data-content="">
                <img class="msg" src=" <?php echo $oimg_link ?> "></a>:
                <a><?php echo $ttitle ?></a>
                </span>
              </div>
              <div id="collapse<?php echo $i ?>" class="accordion-body collapse">
                <div class="accordion-inner">
                <p><a><?php echo $oname ?></a>说:</p>
                <blockquote><p class="quote"><?php echo $tcontent; ?></p></blockquote>
                <p><small><?php echo $ttime; ?></small></p>
                </div>
              </div>
            </div>
<?php
}
?>





          </div>


          <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br>
          <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br>
        </div>
    </div>

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap-transition.js"></script>
    <script src="js/bootstrap-alert.js"></script>
    <script src="js/bootstrap-modal.js"></script>
    <script src="js/bootstrap-dropdown.js"></script>
    <script src="js/bootstrap-scrollspy.js"></script>
    <script src="js/bootstrap-tab.js"></script>
    <script src="js/bootstrap-tooltip.js"></script>
    <script src="js/bootstrap-popover-zh.js"></script>
    <script src="js/bootstrap-button.js"></script>
    <script src="js/bootstrap-collapse.js"></script>
    <script src="js/bootstrap-carousel.js"></script>
    <script src="js/bootstrap-typeahead.js"></script>
    <script src="js/application-zh.js"></script>
    <script src="js/xmlhttp.js"></script>
    <script type="text/javascript">
    function setfriend(user) {
        var target="action/setfriend_do.php";
        var req="target="+user;
        var callback=function() {
            if (xmlhttp.readyState==4 && xmlhttp.status==200) {
                var resp=xmlhttp.responseText;
                resp=$.trim(resp);
                setTimeout(function(){
                    $("#w"+user).css('display','none');
                    $("#wd"+user).css('display','inline');
                },2000);
            }
        }
        xmlhttp_req(target,req,callback);
    }
    function delfriend(user) {
        var target="action/delfriend_do.php";
        var req="target="+user;
        var callback=function() {
            if (xmlhttp.readyState==4 && xmlhttp.status==200) {
                var resp=xmlhttp.responseText;
                resp=$.trim(resp);
                $("#wd"+user).css('display','none');
                $("#w"+user).css('display','inline');
            }
        }
        xmlhttp_req(target,req,callback);
    }
    </script>
  </body>
</html>
