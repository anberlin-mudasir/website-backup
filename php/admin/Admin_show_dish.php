<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns = "http://www.w3.org/1999/xhtml">
<head> 
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>菜肴信息</title> 
  <link href="../../css/base.css" type="text/css" rel="stylesheet"/>
  <link href="../../css/login.css" type="text/css" rel="stylesheet"/>
  <link href="../../css/user.css" type="text/css" rel="stylesheet"/>
  <link href="../../css/shop-min.css" type="text/css" rel="stylesheet"/>
</head> 

<body>
<?php include('common_admininfo.php') ?>
<?php
include('mysql_db.php');

$query='select * from admin where name="'.$useername.'"';
$query=stripslashes($query);
$result=mysql_query($query);
$num=mysql_num_rows($result);
if($num==0)
{
    echo "<script>window.alert(\"请先登录\");window.location='../../index.html';</script>";
    die('');
}
?>

<?php include('header_admin.php'); ?>
<div class="main_w">
  <br />
  <div class="content_n">
    <div class="memberBox">
      <h3>菜肴信息</h3>
    </div>

<?php
if (isset($_POST['Number']))
{
    $Number = $_POST['Number'];
}
else
    die('<meta http-equiv="refresh" content="1;URL=../../index.html">出错了，返回首页！');

$style = array("鲁菜","川菜","苏菜","粤菜","浙菜","闽菜","湘菜","徽菜","东北菜","其他");
$prime = array(2,3,5,7,11,13,17,19);
$primenum = array(0,1,0,1,4,2,6,3,8,9,10,4,12,5,14,15,16,6,18,7,20);
$canteenarr = array("学一","学五","艺园","家园","农园","燕南","康博思","佟园");
$tastearr = array("酸","甜","苦","辣","咸","淡","麻","鲜");

$query = 'select * from dishes where Number = '.$Number;
$result = mysql_query($query,$db);

$row = mysql_fetch_array($result);
extract($row);

$allTaste = "";
for($i=0;$i<=7;$i++){
    if($Taste % $prime[$i] == 0)
        $allTaste = $tastearr[$i];
    for($j = $i + 1;$j <= 7;$j ++){
        if($Taste % $prime[$j] == 0){
            $allTaste = $allTaste.' ';
            $allTaste = $allTaste.$tastearr[$j];
        }
    }
    break;
}
?>

    <div class="feedList">
      <table class="min-table">
      <tr>
      <td rowspan="6"><input width="249" type="image" height="168" alt="" src="../../image/<?php echo $Url_of_image; ?>"/></td>
        <td><strong><?php echo $Name; ?></strong>
        <div class="min-mark-box">
          <span class="btn-type-a btn-fn-a">
            <a class="form-btn min-mark" href="javascript:document.change.submit()">修改</a>
          </span>
          <span class="btn-type-a btn-fn-a">
            <a class="form-btn min-mark" href="javascript:document.del.submit()">删除</a>
          </span>
        </div>
        </td>
      </tr>
      <tr><td>
      <span>食堂: <span class="min-canteen"><?php echo $canteenarr[$primenum[$Canteen]];?></span></span>
      <span>价格: <span class="min-price">¥<?php echo $Price;?></span></span>
      <span>评分: <span class="min-score"><?php echo round($Grade,2)?></span></span>
      </td></tr>
      <tr><td><span>食料: <?php echo $Ingredients; ?></span></td></tr>
      <tr><td><span>菜系: <?php echo $style[$Style-1]; ?></span></td></tr>
      <tr><td><span>口感: <?php echo $allTaste; ?></span></td></tr>
      <tr><td><span class="min-des"><?php echo $Description; ?></span></td></tr>
      </table>
    </div>
  </div>

<!--Tool box-->
  <div class="asider_n">
    <div class="box tools">
      <p>
        <form name="add" action="./Admin_add_dish.php" method="post">
        <?php include('common_post.php');?>
        </form>
        <span class="item itoolsUpface">
          <a class="B" href="javascript:document.add.submit()">添加菜肴</a>
        </span>
      </p>
      <p>
        <form name="back" action="./Admin_log.php" method="post">
        <?php include('common_post.php');?>
        </form>
        <span class="item itoolsStyle">
          <a class="B" href="javascript:document.back.submit()">返回主面板</a>
        </span>
      </p>
    </div>
  </div>

<!--User comment -->
  <div class="content_n">
  <br />
    <div class="memberBox">
<?php
$num=0;
if(NULL != $Opinion_table_name)
{
	$query = 'select * from '.$Opinion_table_name;
    $result = mysql_query($query,$db);
    $num=mysql_num_rows($result);
?>
    <h3>用户评论共<?php echo $num;?>条</h3>
<?php
	while($row2 = mysql_fetch_array($result))
	{
		extract($row2);
?>
    <div class="feedList">
      <ul><li>
      <span class="time"><?php echo $Time;?></span>
        <?php echo $User ?>说：<?php echo $Opinion; ?>
      </li></ul>
    </div>
<?php
    }
}
else
{
?>
    <h3>没有用户作出过评论</h3>
  </div>
<?php
}
?>
</div>

<form name="del" method="post" action="./Admin_del_dish_do.php">
<?php include('common_post.php') ?>
<input type="hidden" name="deleteNumber[]" value="<?php echo $Number; ?>"/>
</form>

<form name="change" method="post" action="./Admin_update_dish.php">
<?php include('common_post.php') ?>
<input type="hidden" name="modify" value="<?php echo $Number; ?>"/>
</form>
</body>
</html>
