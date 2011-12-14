<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns = "http://www.w3.org/1999/xhtml">
	<head> 
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>修改菜肴</title> 
		<style>
		body 
		{
			background-image:url(../../image/updateDish_back.jpg);
			text-align:center;
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

<script language="javascript" type="text/javascript">
   <!--    
	function checkSubmit2(){
		var q = document.getElementById("contents");
		var bok = true;
		var i,j;
		var tastearr = new Array("酸","甜","苦","辣","咸","淡","麻","鲜");
		if(q.Name.value == "" || q.Ingredients.value == ""
		|| q.Price.value == "" 
		|| q.Description.value == "")
		{bok = false;}
		
		q.allTaste.value = "";
		q.allTasteInC.value = "";
		for(i = 0;i <= 7;i ++){
			if(q.Taste[i].checked){
				q.allTaste.value += q.Taste[i].value;
				q.allTasteInC.value += tastearr[i];
				for(j = i +1;j <= 7;j ++){
					if(q.Taste[j].checked){
					q.allTaste.value += ' ';
					q.allTaste.value += q.Taste[j].value;
					q.allTasteInC.value += ' ';
					q.allTasteInC.value += tastearr[j];
					}
				}
				break;
			}
		}
		if("" == q.allTasteInC.value)
			bok = false;
		
		
		if(false == bok)
		{
			window.alert("不能有空项");
			q.Name.focus();
			return false; 
		}
		
	 ////////////////////////////////////////
    return true;
   } // checkSubmit
  //  -->
</script>

<div><h1>北京大学餐饮信息查询系统</h1></div>

<?php
$db = mysql_connect("","se","se");
mysql_select_db('meal',$db);

$number = $_POST['modify'];

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
	echo "<td><form  id=\"return\" action=\"./showIt.php\" method=\"post\" style=\"color:#039\">";
	echo "<input type=\"hidden\" name=\"user\" value=\"".$useername."\" />";
	echo "<input type=\"hidden\" name=\"Number\" value=\"".$number."\" />"; //Number
	echo "<div onclick=\"document.getElementById('return').submit();\" style=\"cursor:hand;\">&nbsp;&nbsp;返回</div></form>";
	echo "</td></tr></table>";
}

$stylearr = array("鲁菜","川菜","苏菜","粤菜","浙菜","闽菜","湘菜","徽菜","东北菜","其他菜");
$primenum = array(0,1,0,1,4,2,6,3,8,9,10,4,12,5,14,15,16,6,18,7,20);
$canteenarr = array("学一","学五","艺园","家园","农园","燕南","康博思","佟园");
$prime = array(2,3,5,7,11,13,17,19);
$tastearr = array("酸","甜","苦","辣","咸","淡","麻","鲜");



$query = 'select * from dishes where Number = '.$number;
$result = mysql_query($query,$db);
if($row = mysql_fetch_array($result)){
	extract($row);
}

?>



<form action = "./doUpdate.php" onSubmit = "return checkSubmit2();" method = "post" enctype="multipart/form-data" id="contents">

<p/>
<p/>

<?php	
echo "<input type=\"hidden\" name=\"user\" value=\"".$useername."\" />"; //用户名
echo '<h4 style = "color:blue;text-align:center">请填写您需要修改的项目</h4><br/>'; 
echo '<h4>名字:<input type="text" name="Name" value="'.$Name.'"/></h4>'; 
echo '<h4>原料:<input type="text" name="Ingredients" value="'.$Ingredients.'"/></h4>';
echo '<p>如果有多种原料，以空格分开</p>';
echo '<h4>价格:<input type="text" name="Price" value="'.round($Price,2).'"/></h4>';
echo '<h4>图片描述:<input type="file"  id="filer" name="Url_of_image" value="'.$Url_of_image.'"/></h4>';
echo '<h4>菜肴描述:</h4><p>';
echo '<textarea name="Description" rows="15" cols = "60">'.$Description.'</textarea></p>';


echo '<p><b>口感: </b>';
for($i = 0; $i <= 7; $i ++)
{
	if($Taste % $prime[$i] == 0)
		echo '<input type = "checkbox"  name = "Taste"  value = "'.$prime[$i].'"  checked = "checked"/>'.$tastearr[$i];
	else
		echo '<input type = "checkbox"  name = "Taste"  value = "'.$prime[$i].'"/>'.$tastearr[$i];
	//	echo '<input type = "checkbox"  name = "Taste"  value = "3"  /> 甜 ';
}


echo '<input type = "hidden"  name = "allTaste"  value = ""  />';
echo '<input type = "hidden"  name = "allTasteInC"  value = ""  />';


echo '<p><b>菜系: </b>';

for($i = 0; $i <= 9; $i ++)
{
	if($Style == ($i+1))
		echo '<input type = "radio"  name = "Style"  value = "'.($i+1).'"  checked = "checked"/>'.$stylearr[$i];
	else
		echo '<input type = "radio"  name = "Style"  value = "'.($i+1).'"/>'.$stylearr[$i];
}

echo '</p>';
echo '<p><b>食堂: </b>';
for($i = 0; $i <= 7; $i ++)
{
	if($Canteen % $prime[$i] == 0)
		echo '<input type = "radio"  name = "Canteen"  value = "'.$prime[$i].'"  checked = "checked"/>'.$canteenarr[$i];
	else
		echo '<input type = "radio"  name = "Canteen"  value = "'.$prime[$i].'"/>'.$canteenarr[$i];
}
echo '</p>';

echo '<p>
<input type = "hidden" name = "number" value = "'.$Number.'">
<input type = "submit"  value = "确定修改" />
</p>';

?>


</form>

<hr />
</body>
</html>
