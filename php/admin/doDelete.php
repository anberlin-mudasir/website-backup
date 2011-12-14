<?xml version = "1.0" encoding = "utf-8" encoding="utf-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns = "http://www.w3.org/1999/xhtml">
	<head> 
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>删除成功</title> 
	<style>
		body 
		{
			background-image:url(../../image/deleteDish_back.jpg);
			text-align:center;
			font-size:20px;
		}
		h1 
		{
			filter:glow(color=#FF0,strength=5);
			font-size:38px; 
			font-family:STXinwei,STXingkai,SimHei;
		}
		table {
		margin-left:auto;
		margin-right:auto;
		}
	</style>
	</head> 
	

<body>

<br/><br/>

<div><h1>北京大学餐饮信息查询系统</h1></div>


<?php
//connect to MySql
$db = mysql_connect("","se","se");
mysql_select_db('meal',$db);


//用户验证
$useername=$_POST['user'];
$query='select * from admin where name=\"'.$useername.'\"';
$query=stripslashes($query);
$result=mysql_query($query);
$num=mysql_num_rows($result);
if($num==0)
	echo "<script>window.alert(\"请先登录\");window.location='../../Admin/Admin_log.html';</script>";
else
{
	echo "<table style=\"text-align:right; margin-right:50px; font-size:20px;\" ><tr><td>";
	echo "<div style=\"color:#039\">欢迎".$useername."</div></td";
	echo "<td><form  id=\"return\" action=\"./deleteDish.php\" method=\"post\" style=\"color:#039\">";
	echo "<input type=\"hidden\" name=\"user\" value=\"".$useername."\" />";
	echo "<input type=\"hidden\" name=\"start\" value=\"0\" />"; //页数
	echo "<div onclick=\"document.getElementById('return').submit();\" style=\"cursor:hand;\">&nbsp;&nbsp;返回</div></form>";
	echo "</td></tr></table>";
}

$stylearr = array("鲁菜","川菜","苏菜","粤菜","浙菜","闽菜","湘菜","徽菜","东北菜","其他");
$primenum = array(0,1,0,1,4,2,6,3,8,9,10,4,12,5,14,15,16,6,18,7,20);
$canteenarr = array("学一","学五","艺园","家园","农园","燕南","康博思","佟园");


$canteen_count = count($_POST['deleteNumber']);
$canteen_tmp=$_POST['deleteNumber'];

for ($i = 0; $i < $canteen_count; $i++)
{
	$query = 'select * from dishes where Number = '.$canteen_tmp[$i];
	$result = mysql_query($query,$db);
	if($row = mysql_fetch_array($result)){
		extract($row);
		if(NULL != $Opinion_table_name)
		{
			$query = 'drop table '.$Opinion_table_name;
			$result = mysql_query($query,$db);
	//		echo $query;
		}
	}
	//删除图片
	if($Url_of_image!="")
	{
		$filername="../../image/".$Url_of_image;
		if(file_exists($filername))
			unlink($filername);
	}
    $query = 'delete from dishes where Number = '.$canteen_tmp[$i];
	mysql_query($query,$db);
}

echo '<h2 style="text-align:center">删除成功</h2>'

?>

<br/>

</body>
</html>
