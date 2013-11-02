<?php
include('common/cookie.php');
if ($name=="" || $pwd=="") {
    $res="none";
    header("Location: login.php"); 
}
include('common/user.php');
if (($res = trim(verify($name,$pwd))) != "success") {
    header("Location: index.php"); 
}
include('common/identicon.php');
$identicon=new identicon;
$img_link=$identicon->identicon_build($name,'[alt]',false);

include('common/msg.php');
include('common/friend.php');
//echo $name."<br>".$pwd;
$key="";
$page=0;
$hits=array();
$num_hit=0;
if (isset($_GET['key'])) {
    $key=$_GET['key'];
    $res=trim(search($key,$name,$pwd));
    foreach(preg_split("/((\r?\n)|(\r\n?))/", $res) as $line){
        $hits[$num_hit] = $line;
        $num_hit++;
    }
}
if ($num_hit == 1 && $hits[0] == "fail") {
    $num_hit=0;
}
$per_page=10;
$num_page=intval(($num_hit/2+$per_page-1)/$per_page);
//$num_hit=intval($num_hit/2);
if (isset($_GET['page'])) {
    $page=$_GET['page'];
}
if ($page > $num_page) {
    $page=$num_page;
} else if ($page < 0) {
    $page=0;
}
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
              <li class="active"><a href="#"><i class="icon-search"></i> 搜索结果</a></li>
            </ul>
          </div>
            <ul class="nav pull-right">
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">帐号 <b class="caret"></b></a>
                <ul class="dropdown-menu">
                <li><a><img src="<?php echo $img_link ?>" class="img-polaroid usr"><?php echo $name ?> </a>
                  </li>
                  <li class="divider"></li>
                  <li><a href="./logout.php"><i class="icon-off"></i> 注销</a></li>
                </ul>
              </li>
            </ul>
        </div>
      </div>
    </div>

    <div class="container">
    <div class="span2"></div>
    <div class="span8">
        <div class="input-prepend input-append">
            <form method="get" action="./search.php">
            <span class="add-on"><i class="icon-search"></i></span>
            <input name="key" class="span2" id="appendedPrependedInput" type="text" value="<?php echo $key ?>">
            <button class="btn" type="submit">重新搜索</button>
            </form>
        </div>
        <hr>
          <div id="accordion2" class="accordion">

<?php
if ($num_hit == 0) {
    echo "咦，没有搜到对应用户哦~";
} else {
    echo "共找到<strong>".intval($num_hit/2)."</strong>条结果";
}
for ($i=$page*$per_page*2; $i<$num_hit && $i<($page+1)*$per_page*2 ; $i+=2) {
    $tname=$hits[$i];
    $twatch=$hits[$i+1];
    $timg=$identicon->identicon_build($tname,'[alt]',false);
    $res=trim(fetch_msg($tname, $name, $pwd));
    $res=preg_split("/((\r?\n)|(\r\n?))/", $res);
    if (sizeof($res) == 1 && $res[0] == "false" ) {
        $ttitle="(这个人很懒，什么都没写)";
    } else {
        if (mb_strlen($res[0],'utf-8')>30)
            $ttitle=mb_substr($res[0],0,30,'utf-8')."...";
        else
            $ttitle=$res[0];
    }
?>
            <div class="accordion-group">
              <div class="accordion-heading">
                <span class="accordion-toggle">
                <img class="msg" src="<?php echo $timg ?>"> <a href="./othr.php?name=<?php echo $tname ?>"><?php echo $tname ?></a>:
                <?php echo $ttitle ?>
<?php 
    if ($twatch=="false" && $tname != $name) {
?>
    <button data-loading-text="<strong>关注中...</strong>" id="w<?php echo $tname ?>" onclick="javascript:setfriend('<?php echo $tname ?>')" class="btn btn-small btn-primary pull-right fat-btn"><i class="icon-plus icon-white"></i> <strong>关注</strong></button>
    <button id="wd<?php echo $tname ?>" style="display:none" class="btn btn-small btn-success pull-right disabled"><i class="icon-ok icon-white"></i> <strong>已关注</strong></button>
<?php
    } else if ($tname != $name) {
?>
    <button class="btn btn-small btn-success pull-right disabled"><i class="icon-ok icon-white"></i> <strong>已关注</strong></button>
<?php
    }
?>
                </span>
              </div>
            </div>
<?php
}
?>
          </div>
            <hr>
            <div class="pagination pull-right">
                <ul>
<?php
if ($page-1<0) {
    echo "<li class='active'><a href='#'>«</a></li>";
} else {
    echo "<li><a href='?key=".$key."&page=".($page-1)."'>«</a></li>";
} 
for ($i=0; $i<$num_page; $i++) {
    $type="";
    if ($i==$page) {
        $type=" class='active'";
    }
    $href="?key=".$key."&page=".$i;
    echo "<li".$type."><a href='".$href."'>".($i+1)."</a></li>";
?>
<?php
}

if ($page+1>=$num_page) {
    echo "<li class='active'><a href='#'>»</a></li>";
} else {
    echo "<li><a href='?key=".$key."&page=".($page+1)."'>»</a></li>";
}
?>
            </ul>
         </div>
    </div>
    <div class="span2"></div>
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
    </script>
  </body>
</html>
