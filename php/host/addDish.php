<?xml version = "1.0" encoding = "utf-8" encoding="utf-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns = "http://www.w3.org/1999/xhtml">
	<head> 
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>添加成功</title> 
	<style>
		body 
		{
			background-image:url(../../image/dish_back.gif);
			text-align:center;
			font-size:20px;
		}
		h1 
		{
			filter:glow(color=#FF0,strength=5);
			font-size:38px; 
			font-family:STXinwei,STXingkai,SimHei;
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
	echo "<div style=\"color:#039\">欢迎".$useername."</div></td>";
	echo "</tr></table>";
	echo "</tr></table>";
}

$stylearr = array("鲁菜","川菜","苏菜","粤菜","浙菜","闽菜","湘菜","徽菜","东北菜","其他");
$primenum = array(0,1,0,1,4,2,6,3,8,9,10,4,12,5,14,15,16,6,18,7,20);
$canteenarr = array("学一","学五","艺园","家园","农园","燕南","康博思","佟园");


//insert
$Name = trim($_POST['Name']);
$Ingredients = trim($_POST['Ingredients']);
$Price = trim($_POST['Price']);
$Description = $_POST['Description'];
$Style = $_POST['Style'];
$Canteen = $_POST['Canteen'];
$useername=$_POST['user'];

//上传文件
if ($_FILES["Url_of_image"]["error"] > 0)
  {
  echo "Error: " . $_FILES["Url_of_image"]["error"] . "<br />";
  }
move_uploaded_file($_FILES["Url_of_image"]["tmp_name"],
      "../../image/" . $_FILES["Url_of_image"]["name"]);
$Url_of_image=$_FILES["Url_of_image"]["name"];

$Taste = 1;
if($_POST['allTaste'] != ""){
	$Taste_tmp = explode(" ", $_POST['allTaste']); 
	$Taste_count = count($Taste_tmp);
	for ($i = 0; $i < $Taste_count; $i++)
	{
		$Taste *= $Taste_tmp[$i];
	}
}

$query = "insert into dishes (Name,Ingredients,Price,Url_of_image,Description,
			Taste,Style,Canteen,Guest_count,Grade)
	VALUES
	('$Name','$Ingredients','$Price','$Url_of_image','$Description',
			'$Taste','$Style','$Canteen',0,0)";
			
mysql_query($query,$db);

echo '<p style = "text-align:center;color:blue">添加成功</p>';
echo '<p >菜名:'.$Name.'</p>';
echo '<p style = "text-align:center">食料:'.$Ingredients.'</p>';
echo '<p style = "text-align:center">价格:'.$Price.'</p>';
echo '<p style = "text-align:center">口感:'.$_POST['allTasteInC'].'</p>';
echo '<p style = "text-align:center">菜系:'.$stylearr[$Style-1].'</p>';
echo '<p style = "text-align:center">食堂:'.$canteenarr[$primenum[$Canteen]].'</p>';

?>


<br/>
<?php
	echo "<p><form  id=\"continue\" action=\"./dish.php\" method=\"post\" style=\"color:#00F\">";
	echo "<input type=\"hidden\" name=\"user\" value=\"".$useername."\" />";
	echo "<div onclick=\"document.getElementById('continue').submit();\" style=\"cursor:hand;\"><p>继续添加<br /></p></div></form></p>";
	echo "<p><form  id=\"remain\" action=\"./Admin_log.php\" method=\"post\" style=\"color:#00F\">";
	echo "<input type=\"hidden\" name=\"user\" value=\"".$useername."\" />";
	echo "<input type=\"hidden\" name=\"test\" value=\"true\" />";
	echo "<input type=\"hidden\" name=\"useername\" value=\"".$useername."\" />";
	echo "<input type=\"hidden\" name=\"password\" value=\"\" />";
	echo "<div onclick=\"document.getElementById('remain').submit();\" style=\"cursor:hand;\"><p>返回菜单<br /></p></div></form></p>";
?>

  


</body>
</html>
