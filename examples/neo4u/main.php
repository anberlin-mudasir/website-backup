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
$num_news=0;
$msg=array();
$res=trim(fetch_news($name, $pwd));
foreach(preg_split("/((\r?\n)|(\r\n?))/", $res) as $line){
    $msg[$num_news] = $line;
    $num_news++;
} 
if ($num_news == 1)
    $num_news = 0;

include('common/friend.php');
$num_friend=trim(fetch_friendnum($name, $name, $pwd));
$num_rfriend=trim(fetch_reversefriendnum($name, $name, $pwd));
$num_recommend=0;
$res=trim(fetch_recommendfriends($name, $pwd));
foreach(preg_split("/((\r?\n)|(\r\n?))/", $res) as $line){
    $recommend[$num_recommend] = $line;
    $num_recommend++;
} 
if ($num_recommend == 1 && $recommend[0] == "fail")
    $num_recommend = 0;

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
              <li class="active"><a href="#"><i class="icon-home"></i> 首页</a></li>
              <li><a href="./self.php"><i class="icon-user"></i> 个人主页</a></li>
            </ul>
          </div>
            <ul class="nav pull-right">
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">帐号 <b class="caret"></b></a>
                <ul class="dropdown-menu">
                <li><a><img src="<?php echo $img_link ?>" class="img-polaroid usr">  <?php echo $name ?></a>
                  </li>
                  <li class="divider"></li>
                  <li><a href="./logout.php"><i class="icon-off"></i> 注销</a></li>
                </ul>
              </li>
            </ul>
            <form class="navbar-search pull-right" method="get" action="search.php">
              <input name="key" type="text" class="search-query" placeholder="搜索好友">
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
                <td rowspan="3"><img src="<?php echo $img_link ?>" class="img-polaroid usr"></td>
                <td colspan="2"><a href="./self.php"><strong><?php echo $name ?></strong></a></td>
                </tr>
                <tr><td><b><i class="icon-share"></i><small>关注</small></b></td>
                <td><b><i class="icon-eye-open"></i><small>粉丝</small></b></td></tr>
                <tr><td><?php echo $num_friend ?></td>
                <td><?php echo $num_rfriend ?></td></tr>
                </table>
                <hr>
                <div class="well recommend">
                <strong><small>推荐好友</small></strong><br><br>
                <table><tr>

<?php
if ($num_recommend == 0 && $num_friend != 0) {
    echo "<label class='label label-info'>恭喜!</label><br>你好友关注的人你都关注了!";
} else if ($num_recommend == 0){
    echo "<p class='alert alert-info'>或许，你可以尝试一下右上角的搜索功能，找找你想关注的人?</p>";
}
for ($i=0; $i<$num_recommend; $i++) {
    $tname=$recommend[$i];
    $timg=$identicon->identicon_build($tname,'[alt]',false);
?>
    <td rowspan="2"><img src="<?php echo $timg ?>" class="img-polaroid recommend"></td><td><a href="./othr.php?name=<?php echo $tname ?>"><?php echo $tname ?></a></td>
                </tr><tr>
                <td>
                <a href="javascript:setfriend('<?php echo $tname ?>')"><span data-loading-text="关注中" class="label label-info fat-btn" id="w<?php echo $tname ?>">+ 关注</span></a>
                <a><span class="label label-success" style="display:none" id="wd<?php echo $tname ?>">已关注</span></a>
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
          <form action="javascript:report()">
          <textarea id="report" class="msg" rows="4" maxlength="200" onblur="check()" onkeyup="check()"></textarea><br>
          <button id="submit" type="sumbit" data-loading-text="发布中..." class="fat-btn btn btn-primary pull-right disabled">发布</button>
          <strong><small>计<span id="cnt">0</span>/200字</small></strong>
          </form>
          <br> <br>
          <div class="accordion" id="accordion2">

<?php
$max_time="";
for ($i=0; $i<$num_news; $i+=3) {
    $tname=$msg[$i];
    $tcontent=$msg[$i+1];
    $ttime=$msg[$i+2];
    if (mb_strlen($tcontent,'utf-8')>30)
        $ttitle=mb_substr($tcontent,0,30,'utf-8')."...";
    else
        $ttitle=$tcontent;
    $timg=$identicon->identicon_build($tname,'[alt]',false);
    if ($ttime > $max_time)
        $max_time = $ttime;
?>

            <div class="accordion-group fade in">
            <a onclick="javascript:setread(<?php echo $i ?>)" href="#" class="fade close" data-dismiss="alert">&times;</a>
              <div class="accordion-heading">
                <span class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse<?php echo $i ?>">
                <a data-original-title="<img src='<?php echo $timg; ?>'/>  <a href=''><?php echo $tname ?></a>" href="./othr.php?name=<?php echo $tname ?>" class="popover-test" data-content="">
                <img class="msg" src="<?php echo $timg; ?>"></a>:

                <a><?php echo $ttitle; ?></a>
                </span>
              </div>
              <div id="collapse<?php echo $i ?>" class="accordion-body collapse">
                <div class="accordion-inner">
                <p><a href="./othr.php?name=<?php echo $tname ?>" id="name<?php echo $i ?>"><?php echo $tname ?></a>说:</p>
                <blockquote><p class="quote"><?php echo $tcontent ?></p></blockquote>
                <p><small id="time<?php echo $i ?>"><?php echo $ttime ?></small></p>
                </div>
              </div>
            </div>


<?php 
}
?>
          </div>
<?php
if ($num_news != 0) {
?>
    <small class='allread'><a href="javascript:setallread()">全部标记为已读</a></small>
    <small class='nonews' style='display:none'>没有新鲜事了</small>
<?php
} else {
?>
    <small class='allread' style='display:none'><a href="javascript:setallread()">全部标记为已读</a></small>
    <small class='nonews'>没有新鲜事了</small>
<?php
}
?>


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
    function report() {
        var str=$("#report").val().substr(0,200);
        //str=str.replace(/[^\s0-9a-zA-Z\u4E00-\u9FA5]/g,' '); // strip out symbols?
        //str=str.replace(/[^\s0-9a-zA-Z\u4E00-\u9FA5]/g,' ');
        var target="action/report_do.php";
        var req="str="+str;
        var callback=function() {
            if (xmlhttp.readyState==4 && xmlhttp.status==200) {
                var resp=xmlhttp.responseText;
                resp=$.trim(resp);
                setTimeout(function() {
                    $("#report").val("");
                    check();
                },2500);
            }
        }
        xmlhttp_req(target,req,callback);
    }

    function setread(id) {
        var name=$.trim($('#name'+id).html());
        var time=$.trim($('#time'+id).html());
        time=time.replace('+','#');

        var target="action/setread_do.php";
        var req="name="+name+"&time="+time;
        var callback=function() {
            if (xmlhttp.readyState==4 && xmlhttp.status==200) {
                var resp=xmlhttp.responseText;
                resp=$.trim(resp);
            }
        }
        xmlhttp_req(target,req,callback);
    }
    function setallread() {
        var target="action/setread_do.php";
        var req="name=all";
        var callback=function() {
            if (xmlhttp.readyState==4 && xmlhttp.status==200) {
                var resp=xmlhttp.responseText;
                resp=$.trim(resp);
                $(".nonews").css('display','inline');
                $(".allread").css('display','none');
                $("#accordion2").html('');
                //$("#accordion2").html('<small>没有新鲜事了</small>');
            }
        }
        xmlhttp_req(target,req,callback);
    }

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

    <script type="text/javascript">
    function check() {
        var len=$("#report").val().length;
        $("#cnt").html(len);
        if (len==0) {
            $("#submit").addClass("disabled");
        } else {
            $("#submit").removeClass("disabled");
        }
    }
    check();
    </script>

    <script type="text/javascript">
    var numnews=<?php echo $num_news; ?>; 
    var ddl=getddl("0000");
    setTimeout("pull()",2000);

    function getddl(oldddl) {
        var time=oldddl;
        for (i=0; i<numnews; i+=3) {
            var timestamp=$("#time"+i);
            if(timestamp != null) {
                if (time < $.trim(timestamp.html()))
                    time=$.trim(timestamp.html());
            }
        } 
        return time.replace('+','#');
    }
    function shownews() {
           $(".new").fadeIn('slow');
           setTimeout(function(){$(".new").addClass('fade');$(".new").removeClass('new');},2000);
    }
    function pull() {
        var target="action/pullnews_do.php";
        var req="offset="+numnews+"&ddl="+ddl;
        var callback=function() {
            if (xmlhttp.readyState==4 && xmlhttp.status==200) {
                var resp=xmlhttp.responseText;
                resp=$.trim(resp);
                resp=resp.split('\n');
                var info=parseInt(resp[0]);
                resp=resp.slice(1);
                resp=resp.join('\n');
                if (info > 0) {
                    $('#accordion2').html(resp+$('#accordion2').html());
                    $(".nonews").css('display','none');
                    $(".allread").css('display','inline');
                } else {
                    info=0;
                }
                numnews+=info*3;
                ddl=getddl(ddl);
                shownews();
                setTimeout("pull()",5000);
            }
        }
        xmlhttp_req(target,req,callback);
    }
    </script>

  </body>
</html>
