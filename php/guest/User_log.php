<?xml version = "1.0" encoding = "utf-8" encoding="utf-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns = "http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link href="../../css/base.css" type="text/css" rel="stylesheet"/>
  <link href="../../css/login.css" type="text/css" rel="stylesheet"/>
  <link href="../../css/user.css" type="text/css" rel="stylesheet"/>
  <link href="../../css/shop-min.css" type="text/css" rel="stylesheet"/>
  <title>用户界面</title>
</head>
<body>
<?php include("common_userinfo.php"); ?>
<?php 
	error_reporting(E_ALL & ~ E_NOTICE);
	$db = mysql_connect("", "se","se");
	mysql_select_db('meal',$db);
    $query='select * from user where name=\"'.$useername.'\"and pass=\"'.$password.'\"';
	$query=stripslashes($query);
	$result=mysql_query($query);
    $num=mysql_num_rows($result);
	$test=$_POST['test'];
	if($test!="true")
	{
        if($num==0)
        {
            echo "<script>window.alert(\"用户名或密码错误\");window.location='../../index.html';</script>";
            die('');
        }
	}
?>

<?php
    if ($useername!="guest")
        include('header_user.php');
    else
        include('header_guest.php');
?>

<div class="main_w">
  <br />
  <div class="content_n">
    <div class="memberBox">
      <div class="box feedBox">
        <div class="feedTip"><p>点击图片即可获取详细信息</p></div>
      </div>
      <h3>菜肴列表</h3>
    </div>
<?php
$db = mysql_connect("","se","se");
mysql_select_db('meal',$db);
$query = 'select * from dishes';
$result = mysql_query($query,$db);
$totalnum=mysql_num_rows($result);

if (isset($_POST['start']))
    $kai=$_POST['start'];
else
    $kai=0;

$limit=5;
if($kai<=0)
	$kai=0;
else
{
	if($kai>$totalnum-1)
	{
		if($totalnum%$limit!=0)
			$kai=$totalnum-$totalnum%$limit;
		else
			$kai=($totalnum==0)?$totalnum:$totalnum-5;
	}
}

$query = 'select * from dishes limit '.$kai.','. $limit;
$query=stripslashes($query);
$result = mysql_query($query,$db);
while($row = mysql_fetch_assoc($result))
{
    extract($row);
?>
    <div class="feedList">
      <table class="min-table">
      <tr>
        <td rowspan="3">
        <form action="./User_showdish.php" method="post">
        <?php include('common_post.php');?>
<?php
    echo '<input width="249" type="image" height="168" alt="" src="../../image/'.$Url_of_image.'"/>';
	echo '<input type="hidden" name="Number" value="'.$Number.'"/>';
?>
        </form>
        </td>
        <td>
          <strong>
<?php
    echo $Name;
?>
          </strong>
      </td>
      </tr>
      <tr><td><p>价格: 
        <span class="min-price">¥
<?php
    echo $Price;
?>
        </span></p></td></tr>
      <tr><td><p>评分: 
        <span class="min-score">
<?php
    echo round($Grade,2);
?>
        </span></p></td></tr>
      </table>
    </div>
<?php
}
?>
    <div class="Pages">
<?php
$count_i=0;
$count_j=1;
$current=$kai/5+1;
$current0=($current-2)*$limit;
?>
<!--prev page -->
    <a class="PrevPage" title="上一页" href="javascript:document.pre.submit();">上一页</a>
    <form name="pre" class="Hide" action="#" method="post">
<?php
    echo '<input type="hidden" name="start" value="'.$current0.'"/>';
    include('common_post.php');
?>
    </form>
<!--num iteration -->
<?php
while($count_i<$totalnum)
{
    if($current!=$count_j)
        echo '<a class="PageLink" href="javascript:document.getElementById(\'page_'.$count_j.'\').submit();">'.$count_j.'</a>';
    else
        echo '<span class="PageSel" href="javascript:document.getElementById(\'page_'.$count_j.'\').submit();">'.$count_j.'</span>';
    echo '<form id="page_'.$count_j.'" class="Hide" action="#" method="post">';
    echo '<input type="hidden" name="start" value="'.$count_i.'"/>';
    include('common_post.php');
    echo '</form>';
    $count_j++;
    $count_i+=$limit;
}
?>


<!--next page -->
    <a class="NextPage" title="下一页" href="javascript:document.next.submit();">下一页</a>
    <form name="next" class="Hide" action="#" method="post">
<?php
    echo '<input type="hidden" name="start" value="'.($current*$limit).'"/>';
    include('common_post.php');
?>
    </form>


    </div> <!--div Pages-->
  </div>


<!--  tool box -->
  <div class="asider_n">
    <div class="box tools">
<?php
if ($useername!='guest')
{
?>
      <p>
        <form name="alter" action="./User_change_pwd.php" method="post">
        <?php include('common_post.php');?>
        </form>
        <span class="item itoolsSet">
          <a class="B" href="javascript:document.alter.submit();">修改密码</a>
        </span>
      </p>
<?php
}
?>
      <p>
        <form name="search" action="./User_search.php" method="post">
        <?php include('common_post.php');?>
        </form>
        <span class="item itoolsBox">
          <a class="B" href="javascript:document.search.submit()">查找菜肴</a>
        </span>
      </p>
<?php
if ($useername!='guest')
{
?>
      <p>
        <form name="mark" action="./User_showmark.php" method="post">
        <?php include('common_post.php');?>
        </form>
        <span class="item itoolsFavorite">
          <a class="B" href="javascript:document.mark.submit()">查看收藏</a>
        </span>
      </p>
<?php
}
?>
    </div>
  </div>
</div>
</body>
</html>
