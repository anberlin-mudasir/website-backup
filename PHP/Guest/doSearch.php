<?xml version = "1.0" encoding = "utf-8" encoding="utf-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns = "http://www.w3.org/1999/xhtml">
	<head> 
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>查询结果</title> 
			<style>
	body {
		text-align:center;
		background-image:url(../../image/doSearch_back.gif);
	}
	a:visited
	{	
		color:#00F;
	}
	table {
		margin-left:auto;
		margin-right:auto;
	}
	</style>
	</head> 
	

<body>
<?php include('common_userinfo.php') ?>
<div style="text-align:center;">
    <h2 style=" filter:glow(color=#FF0,strength=5); font-size:38px; font-family:STXinwei,STXingkai,SimHei;">北京大学餐饮信息查询系统</h2>
    </div>

	<form id="backSearch" action="./searchDish.php" method="post">
	<input type="hidden" name="start" value="0" />
<?php
	echo "<input type=\"hidden\" name=\"useername\" value=\"".$useername."\" />";
	echo "<input type=\"hidden\" name=\"password\" value=\"".$password."\" />";
    echo "<div onclick=\"document.getElementById('backSearch').submit();\" style=\"cursor:hand;\"><a href=\"#\"><p>返回<br /></p></a></div></form>";
?>
	</form>

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

//connect to MySql
$db = mysql_connect("","se","se");
mysql_select_db('meal',$db);

//search
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

//展示查询结果

echo '<table border = "border">';
echo '<tr><th>菜名</th><th>价格</th><th>得分</th><th>图片</th></tr>';
while($row = mysql_fetch_assoc($result))
{
	extract($row);
	//对原料的进一步删选
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
	echo '<tr>';
	echo '<th>'.$Name.'</a></th>';
	echo '<th>'.$Price.'</th>';
	echo '<th>'.round($Grade,2).'</th>';
    echo '<th ><form action = "./showChooseDish.php" method = "post">';
	echo "<input type=\"hidden\" name=\"useername\" value=\"".$useername."\" />";
	echo "<input type=\"hidden\" name=\"password\" value=\"".$password."\" />";
	echo '<input type = "image" src = "../../image/'.$Url_of_image.'" alt = "" width="249" height="168"/>';
	echo '<input type = "hidden" name = "Number" value = "'.$Number.'">';
	echo '</form></th>';
	echo '</tr>';
}

echo '</table>';
?>

</body>
</html>
