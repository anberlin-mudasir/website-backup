<?xml version = "1.0" encoding = "utf-8" encoding="utf-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns = "http://www.w3.org/1999/xhtml">
	<head> 
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>评论成功</title> 
		<style>

		</style>
	</head> 
	

<body>



<?php
//data
$newGrade = $_POST['Grade'];
$newOpinion = $_POST['Opinion'];
$Dish = $_POST['Dish_number'];
?>
<div style="text-align:center;">
    <h1 style=" filter:glow(color=#FF0,strength=5);font-size:38px; font-family:STXinwei,STXingkai,SimHei;">北京大学餐饮信息查询系统</h1>
    </div>
    </div>
		<form id="form1" action="./showChooseDish.php" method="post">
<?php
	echo '<input type="hidden" name="Number" value="'.$Dish.'" />';
?>
	</form>
<div onclick="document.getElementById('form1').submit();" style="cursor:hand; color:#00F;text-align:right;">返回</div>
<br/>
<hr/>

<br/><br/>
<?php
//connect to MySql
$db = mysql_connect("","se","se");
mysql_select_db('meal',$db);

$query = 'select * from dishes where Number = '.$Dish;
$result = mysql_query($query,$db);

if($row = mysql_fetch_array($result))
{
	extract($row);
	$query = 'update dishes set Grade = ('.$Grade.' * '.$Guest_count.' + '.$newGrade.') / ('.$Guest_count.' + 1) where Number = '.$Dish;
	$result = mysql_query($query,$db);
	$query = 'update dishes set Guest_count = ('.$Guest_count.' + 1) WHERE Number = '.$Dish;
	$result = mysql_query($query,$db);
	
	if($newOpinion != NULL){
		if(NULL == $Opinion_table_name)
		{
			$Opinion_table_name = 'guest_opinions_'.$Number;
			$query = 'update dishes set Opinion_table_name = "'.$Opinion_table_name.'" WHERE Number = '.$Dish;
			//echo $query;
			$result = mysql_query($query,$db);
			$query = 'create table '.$Opinion_table_name.' (Opinion text)';
			$result = mysql_query($query,$db);
		}
		$query = 'insert into '.$Opinion_table_name.' values(\''.$newOpinion.'\')';
		$result = mysql_query($query,$db);
	}

}

echo '<p style = "text-align:center;color:blue">评论成功！'.$Number.'</p>';

?>


</body>
</html>
