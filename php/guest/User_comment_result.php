<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns = "http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link href="../../css/base.css" type="text/css" rel="stylesheet"/>
  <link href="../../css/user.css" type="text/css" rel="stylesheet"/>
  <link href="../../css/shop-min.css" type="text/css" rel="stylesheet"/>
  <link href="../../css/login.css" type="text/css" rel="stylesheet"/>
  <title>菜肴评论</title>
</head>
<body>

<?php include('common_userinfo.php') ?>
<?php
    if ($useername!="guest")
        include('header_user.php');
    else
        include('header_guest.php');
?>

<?php
include('mysql_db.php');

$query ='select * from user where name="'.$useername.'" and pass="'.$password.'"';
$result = mysql_query($query,$db);
$num=mysql_num_rows($result);
?>

<div class="main_w">
  <br />
  <div class="content_n">
    <div class="memberBox">
      <h3>菜肴评论</h3>
    </div>
    <div class="box feedBox">
<?php
if ($num==0)
{
?>
      <div class="feedTip min-fail"><p>
      评论出错!请<a href="../../index.html">登录</a></p>

<?php
    die('');
}
?>

<?php
if (!isset($_POST['Grade']) || !isset($_POST['Opinion']) || !isset($_POST['Number']))
{
?>
      <div class="feedTip min-fail"><p>
      评论出错!请返回<a href="javascript:document.back.submit()">主面板</a></p>
      <form name="back" action="./User_log.php" method="post">
       <?php include('common_post.php');?>
      </form>
<?php
    die('');
}
?>


<?php
    $newGrade = $_POST['Grade'];
    $newOpinion = $_POST['Opinion'];
    $Dish = $_POST['Number'];
    $query = 'select * from dishes where Number = '.$Dish;
    $result = mysql_query($query,$db);

    if($row = mysql_fetch_array($result))
    {
	    extract($row);
	$query = 'update dishes set Grade = ('.$Grade.' * '.$Guest_count.' + '.$newGrade.') / ('.$Guest_count.' + 1) where Number = '.$Dish;
	$result = mysql_query($query,$db);
	$query = 'update dishes set Guest_count = ('.$Guest_count.' + 1) where Number = '.$Dish;
	$result = mysql_query($query,$db);
	
	if($newOpinion != NULL){
		if(NULL == $Opinion_table_name)
		{
			$Opinion_table_name = 'guest_opinions_'.$Number;
			$query = 'update dishes set Opinion_table_name = "'.$Opinion_table_name.'" WHERE Number = '.$Dish;
			$result = mysql_query($query,$db);
			$query = 'create table '.$Opinion_table_name.' (User varchar(255),Opinion text, Time datetime)';
			$result = mysql_query($query,$db);
        }
        date_default_timezone_set('Asia/Chongqing');
        $query = 'insert into '.$Opinion_table_name.' values("'.$useername.'","'.$newOpinion.'","'.date("Y-m-d H:i:s").'")';
		$result = mysql_query($query,$db);
	}
}
?>
      <div class="feedTip min-succeed">
        <p>评论成功！谢谢您的支持。</p>
      </div>
    </div>
  </div>
  <div class="asider_n">
    <div class="box tools">
      <p>
        <span class="item itoolsStyle">
          <a class="B" href="javascript:document.last.submit()">返回</a></p>
          <form name="last" action="./User_showdish.php" method="post">
          <?php include('common_post.php');?>
          <input type="hidden" name="Number" value="<?php echo $Number;?>" />
          </form>
        </span>
      </p>
      <p>
        <span class="item itoolsStyle">
          <a class="B" href="javascript:document.back.submit()">用户面板</a></p>
          <form name="back" action="./User_log.php" method="post">
          <?php include('common_post.php');?>
          </form>
        </span>
      </p>
    </div>
  </div>
</div>
</body>
</html>

