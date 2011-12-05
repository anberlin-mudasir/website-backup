<?xml version = "1.0" encoding = "utf-8" encoding="utf-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns = "http://www.w3.org/1999/xhtml">
	<head> 
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>菜单</title> 
	<style>
	body {
		text-align:center;
		background-image:url(../../image/showAllDishes_back.jpg);
	}
	table {
		background-color:#FFC;
		margin-left:auto;
		margin-right:auto;
	}
	a:visited
	{	
		color:#00F;
	}
	</style>
	</head> 
	

<body>
<div style="text-align:center;">
    <h1 style=" filter:glow(color=#FF0,strength=5);font-size:38px; font-family:STXinwei,STXingkai,SimHei;">北京大学餐饮信息查询系统</h1>
    </div>
<div style="font-size:24px;"><p style="text-align:center"><a href = "../../../index.html">返回首页</a>
<a href = "./searchDish.html">高级检索</a></p></div>
<br/>
<hr/>



<?php
//connect to MySql
$db = mysql_connect("","root","root");
$query = 'CREATE DATABASE IF NOT EXISTS MEAL';
mysql_query($query,$db);
mysql_select_db('MEAL',$db);


$query = 'SELECT* FROM DISHES';
$result = mysql_query($query,$db);
$totalnum=mysql_num_rows($result);
$kai=$_POST['start'];
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

echo '<table border = "border">';
echo '<tr><th>菜名</th><th>价格</th><th>得分</th><th>图片</th></tr>';
$query = 'select * from dishes limit '.$kai.','. $limit;
$query=stripslashes($query);
$result = mysql_query($query,$db);
while($row = mysql_fetch_assoc($result))
{
	extract($row);
	echo '<tr>';
	echo '<th>'.$Name.'</a></th>';
	echo '<th>'.$Price.'</th>';
	echo '<th>'.round($Grade,2).'</th>';
	echo '<th ><form action = "./showChooseDish.php" method = "post">';
	echo '<input type = "image" src = "../../image/'.$Url_of_image.'" alt = ""  width="249" height="168"/>';
	echo '<input type = "hidden" name = "Number" value = "'.$Number.'">';
	echo '</form></th>';
	echo '</tr>';
}
echo '</table>';
echo "<table style=\"text-align:center; margin-left:auto; margin-right:auto; font-size:20px; color:#00F;\"><tr>";
$count_i=0;
$count_j=1;
$current=$kai/5+1;
//显示上一页
echo "<td onclick=\"document.getElementById('pre').submit();\" style=\"cursor:hand;\" >\n";
echo "<form id=\"pre\" action=\"showAllDishes.php\" method=\"post\">\n";
$current0=($current-2)*$limit;
echo "<input type=\"hidden\" name=\"start\" value=\"".$current0."\" />";
echo "<input type=\"submit\" value=\"上一页\" />&nbsp;&nbsp;";
echo "</form></td>";
while($count_i<$totalnum)
{
	if($current!=$count_j)
		echo "<td onclick=\"document.getElementById('".$count_j."').submit();\" style=\"cursor:hand;\" >\n";
	else
		echo "<td onclick=\"document.getElementById('".$count_j."').submit();\" style=\"cursor:hand;color:#F0F\" >\n";
	echo "<form id=\"".$count_j."\" action=\"showAllDishes.php\" method=\"post\">\n";
	echo "<input type=\"hidden\" name=\"start\" value=\"".$count_i."\" />";
	echo "</form>&nbsp;&nbsp;".$count_j."</td>";
	$count_j++;
	$count_i+=$limit;
}
//显示下一页
echo "<td onclick=\"document.getElementById('next').submit();\" style=\"cursor:hand;\" >\n";
echo "<form id=\"next\" action=\"showAllDishes.php\" method=\"post\">\n";
$current=$current*$limit;
echo "<input type=\"hidden\" name=\"start\" value=\"".$current."\" />";
echo "&nbsp;&nbsp;<input type=\"submit\" value=\"下一页\" />";
echo "</form></td>";
echo "</tr></table>";
?>

<br/>

<br/>
<hr/>

</body>
</html>
