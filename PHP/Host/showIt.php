<?xml version = "1.0" encoding = "utf-8" encoding="utf-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns = "http://www.w3.org/1999/xhtml">
	<head> 
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>菜肴-详细信息</title> 
			<style>
		body 
		{
			background-image:url(../../image/showIt_back.jpg);
			text-align:center;
		}
		h1 
		{
			filter:glow(color=#FF0,strength=5);
			font-size:38px; 
			font-family:STXinwei,STXingkai,SimHei;
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

<div><h1>北京大学餐饮信息查询系统</h1></div>
<?php
//connect to MySql
$db = mysql_connect("","root","root");
$query = 'CREATE DATABASE IF NOT EXISTS MEAL';
mysql_query($query,$db);
mysql_select_db('MEAL',$db);
$Number = $_POST['Number'];

//用户验证
$useername=$_POST['user'];
$query='SELECT * FROM admin where name=\"'.$useername.'\"';
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
	
$query = 'SELECT * FROM DISHES WHERE Number = '.$Number;
$result = mysql_query($query,$db);

$style = array("鲁菜","川菜","苏菜","粤菜","浙菜","闽菜","湘菜","徽菜","东北菜","其他");

$prime = array(2,3,5,7,11,13,17,19);
$primenum = array(0,1,0,1,4,2,6,3,8,9,10,4,12,5,14,15,16,6,18,7,20);
$canteenarr = array("学一","学五","艺园","家园","农园","燕南","康博思","佟园");
$tastearr = array("酸","甜","苦","辣","咸","淡","麻","鲜");

//echo $Number."@@".$query;

echo '<table border = "border">';
$row = mysql_fetch_array($result);
{
	extract($row);
	echo '<tr>';
	echo '<th>菜名</th>';
	echo '<th>'.$Name.'</th>';
	echo '</tr>';
	
	echo '<tr>';
	echo '<th>食料</th>';
	echo '<th>'.$Ingredients.'</th>';
	echo '</tr>';
	
	echo '<tr>';
	echo '<th>菜系</th>';
	echo '<th>'.$style[$Style-1].'</th>';
	echo '</tr>';
	
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
	
	echo '<tr>';
	echo '<th>口感</th>';
	echo '<th>'.$allTaste.'</th>';
	echo '</tr>';
	
	echo '<tr>';
	echo '<th>价格</th>';
	echo '<th>'.$Price.'</th>';
	echo '</tr>';
	
	echo '<tr>';
	echo '<th>食堂</th>';
	echo '<th>'.$canteenarr[$primenum[$Canteen]].'</th>';
	echo '</tr>';
	
	echo '<tr>';
	echo '<th>得分</th>';
	echo '<th>'.round($Grade,2).'</th>';
	echo '</tr>';
	
	echo '<tr>';
	echo '<th>图片</th>';
	echo '<th><image src = "../../image/'.$Url_of_image.'" alt = "" width="249" height="168"/></th>';
	echo '</tr>';
	
	echo '<tr>';
	echo '<th>描述</th>';
	echo '<th>'.$Description.'</th>';
	echo '</tr>';	
}
echo '</table>';
//展示评论
echo '<br/><br/><br/><h3 style="text-align:left;font-family:verdana;color:blue">用户评论</h3>';

if(NULL != $Opinion_table_name)
{
	$query = 'SELECT * FROM  '.$Opinion_table_name;
	$result = mysql_query($query,$db);
	$count = 1;
	echo '<hr/>';
	while($row2 = mysql_fetch_array($result))
	{
		extract($row2);
		echo '<p><h4 style = "color:blue">'.$count.'.</h4>';
		echo $Opinion;
		echo '</p>';
		echo '<hr/>';
		$count ++;
	}
}
echo '<br/><form action = "./doDelete.php" method = "post">';
echo "<input type=\"hidden\" name=\"user\" value=\"".$useername."\" />"; //用户名
echo '<input type = "hidden" name = "deleteNumber[]" value = "'.$Number.'"/><input type = "submit" value = "删除"/>';
echo '</form>&nbsp&nbsp&nbsp&nbsp<form action = "./updateDish.php" method = "post">';
echo "<input type=\"hidden\" name=\"user\" value=\"".$useername."\" />"; //用户名
echo '<input type = "hidden" name = "modify" value = "'.$Number.'"/><input type = "submit" value = "修改"/>';


?>

</form>

<br/>

</body>
</html>
