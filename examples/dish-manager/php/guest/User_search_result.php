<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns = "http://www.w3.org/1999/xhtml">
<head> 
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>检索结果</title> 
  <link href="../../css/base.css" type="text/css" rel="stylesheet"/>
  <link href="../../css/login.css" type="text/css" rel="stylesheet"/>
  <link href="../../css/user.css" type="text/css" rel="stylesheet"/>
  <link href="../../css/shop-min.css" type="text/css" rel="stylesheet"/>
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
$name = trim($_POST['Name']);
$ingredients = trim($_POST['Ingredients']);
$style = $_POST['allStyle'];   //0是没选择
$taste = 1;
if($_POST['allTaste'] != ""){
	$taste_tmp = explode(" ", $_POST['allTaste']); 
	$taste_count = count($taste_tmp);
	for ($i = 0; $i < $taste_count; $i++)
	{
    $taste *= $taste_tmp[$i];
	}
}

$canteen = 0;
if($_POST['allCanteen'] != ""){
	$canteen_tmp = explode(" ", $_POST['allCanteen']); 
	$canteen_count = count($canteen_tmp);
	$canteen = 1;
	for ($i = 0; $i < $canteen_count; $i++)
	{
		$canteen *= $canteen_tmp[$i];
	}
}
include('mysql_db.php');


if($name == "")
{
	if($style == 0)  //没选菜系
		$query = 'select * from dishes where Taste%'.$taste.'=0 and '.$canteen.'%Canteen=0';
	else
		$query = 'select * from dishes where Style='.$style.' and Taste%'.$taste.'=0 and '.$canteen.'%Canteen=0';
}
else
{
	if($style == 0)  //没选菜系
		$query = 'select * from dishes where Name like "%'.$name.'%"  and Taste%'.$taste.'=0 and '.$canteen.'%Canteen=0';
	else
		$query = 'select * from dishes where Name like "%'.$name.'%" and Style='.$style.' and Taste%'.$taste.'=0 and '.$canteen.'%Canteen=0';
}
$result = mysql_query($query,$db);
?>

<div class="main_w">
  <br />
  <div class="content_n">
    <div class="memberBox">
      <h3>检索结果</h3>
    </div>

<?php

$num=0;
while($row = mysql_fetch_assoc($result))
{
    extract($row);
    $num++;
    // 对原料筛选
	if($ingredients != ""){
		$ingre_input = explode(" ", $ingredients);
		$ingre_input_count = count($ingre_input);
		$bok = true;
		for ($i = 0; $i < $ingre_input_count; $i++)
		{
			if(false == strstr($Ingredients,$ingre_input[$i]))
				$bok = false;
		}
		if(false == $bok)
			continue;
    }
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
if ($num==0)
    echo '没有找到匹配菜肴!';
?>
  </div>

<!--tool box -->
  <div class="asider_n">
    <div class="box tools">
      <p>
        <form name="search" action="./User_search.php" method="post">
        <?php include('common_post.php');?>
        </form>
        <span class="item itoolsBox">
          <a class="B" href="javascript:document.search.submit()">继续查找</a>
        </span>
      </p>
      <p>
        <form name="back" action="./User_log.php" method="post">
        <?php include('common_post.php');?>
        </form>
        <span class="item itoolsStyle">
          <a class="B" href="javascript:document.back.submit();">返回主面板</a>
        </span>
      </p>
    </div>
  </div>
</div>
</body>
</html>
