<?xml version = "1.0" encoding = "utf-8" encoding="utf-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns = "http://www.w3.org/1999/xhtml">
	<head> 
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>修改 成功</title> 
	<style>
		body 
		{
			background-image:url(../../image/updateDish_back.jpg);
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
error_reporting(E_ALL & ~ E_NOTICE);
//connect to MySql
$db = mysql_connect("","root","root");
$query = 'CREATE DATABASE IF NOT EXISTS MEAL';
mysql_query($query,$db);
mysql_select_db('MEAL',$db);

$number=$_POST['number'];
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
	echo "<td><form  id=\"return\" action=\"./showIt.php\" method=\"post\" style=\"color:#039\">";
	echo "<input type=\"hidden\" name=\"user\" value=\"".$useername."\" />";
	echo "<input type=\"hidden\" name=\"Number\" value=\"".$number."\" />"; //Number
	echo "<div onclick=\"document.getElementById('return').submit();\" style=\"cursor:hand;\">&nbsp;&nbsp;返回</div></form>";
	echo "</td></tr></table>";
}
	
$stylearr = array("鲁菜","川菜","苏菜","粤菜","浙菜","闽菜","湘菜","徽菜","东北菜","其他");
$primenum = array(0,1,0,1,4,2,6,3,8,9,10,4,12,5,14,15,16,6,18,7,20);
$canteenarr = array("学一","学五","艺园","家园","农园","燕南","康博思","佟园");


//insert
$Name_new = trim($_POST['Name']);
$Ingredients_new = trim($_POST['Ingredients']);
$Price_new = trim($_POST['Price']);
$Url_of_image_new = $_POST['Url_of_image'];
$Description_new = $_POST['Description'];
$Style_new = $_POST['Style'];
$Canteen_new = $_POST['Canteen'];
$Number_new = $_POST['number'];
//获取本地文件
$query='select * from dishes where Number = '.$Number_new; 
$result=mysql_query($query);
$num=mysql_num_rows($result);
if($row = mysql_fetch_array($result))
	extract($row);
if($_FILES['Url_of_image']['size'] != 0)   //如果上传了文件
{
	//删除本地文件
	if($Url_of_image!="")
	{
		$filername="../../image/".$Url_of_image;
		if(file_exists($filername))
			unlink($filername);
	}

	//上传文件
	if ($_FILES["Url_of_image"]["error"] > 0)
		echo "Error: " . $_FILES["Url_of_image"]["error"] . "<br />";
	move_uploaded_file($_FILES["Url_of_image"]["tmp_name"],
      "../../image/" . $_FILES["Url_of_image"]["name"]);
	$Url_of_image_new=$_FILES["Url_of_image"]["name"];
	//echo $Url_of_image;
}
else
	$Url_of_image_new=$Url_of_image;
$Taste_new = 1;
if($_POST['allTaste'] != ""){
	$Taste_tmp = explode(" ", $_POST['allTaste']); 
	$Taste_count = count($Taste_tmp);
	for ($i = 0; $i < $Taste_count; $i++)
	{
		$Taste_new *= $Taste_tmp[$i];
	}
}



$query = 'update dishes set 
			Name = "'.$Name_new.'",
			Ingredients = "'.$Ingredients_new.'",
			Price = '.$Price_new.',
			Taste = '.$Taste_new.', 
			Style = '.$Style_new.', 
			Description = "'.$Description_new.'", 
			Canteen = '.$Canteen_new.',
			Url_of_image = "'.$Url_of_image_new.'"
		where Number = '.$Number_new; 
					
mysql_query($query,$db);

echo '<p style = "text-align:center;color:blue">修改成功</p>';
echo '<p >菜名:'.$Name_new.'</p>';
echo '<p style = "text-align:center">食料:'.$Ingredients_new.'</p>';
echo '<p style = "text-align:center">价格:'.$Price_new.'</p>';
echo '<p style = "text-align:center">口感:'.$_POST['allTasteInC'].'</p>';
echo '<p style = "text-align:center">菜系:'.$stylearr[$Style_new-1].'</p>';
echo '<p style = "text-align:center">食堂:'.$canteenarr[$primenum[$Canteen_new]].'</p>';

?>


<br/>

</body>
</html>
