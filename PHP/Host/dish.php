<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns = "http://www.w3.org/1999/xhtml">
	<head> 
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>添加菜肴</title> 
		<style>
		body 
		{
			background-image:url(../../image/dish_back.gif);
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
		|| q.Price.value == "" || q.Url_of_image.value == ""
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
			window.alert("不能有未填写项");
			q.Name.focus();
			return false; 
		}
	 ////////////////////////////////////////
    return true;
   } // checkSubmit
  //  -->
</script>


<?php
	error_reporting(E_ALL & ~ E_NOTICE);
	//连接数据库，并确定database
	$db = mysql_connect("", "se","se");
	mysql_select_db('meal',$db);
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
		echo "<td><form  id=\"return\" action=\"./Admin_log.php\" method=\"post\" style=\"color:#039\">";
		echo "<input type=\"hidden\" name=\"test\" value=\"true\" />";
		echo "<input type=\"hidden\" name=\"useername\" value=\"".$useername."\" />";
		echo "<input type=\"hidden\" name=\"password\" value=\"\" />";
		echo "<div onclick=\"document.getElementById('return').submit();\" style=\"cursor:hand;\">&nbsp;&nbsp;返回</div></form>";
		echo "</td></tr></table>";
	}
?>
<div><h1>北京大学餐饮信息查询系统</h1></div>
<form action = "./addDish.php" onSubmit = "return checkSubmit2();" method = "post" enctype="multipart/form-data" id="contents">

<p/>
<p/>	
<h4>名字:<input type="text" name="Name" value=""/></h4> 
<h4>原料:<input type="text" name="Ingredients" value=""/></h4>
<p>如果有多种原料，以空格分开</p>
<h4>价格:<input type="text" name="Price" value=""/></h4>
<h4>图片描述:<input type="file" name="Url_of_image" value=""/></h4>
<h4>菜肴描述:</h4>
<p>
<textarea name="Description" rows="15" cols = "60">
</textarea>
</p>


<p>
<b>口味: </b>
<input type = "checkbox"  name = "Taste"  value = "2"  /> 酸
<input type = "checkbox"  name = "Taste"  value = "3"  /> 甜 
<input type = "checkbox"  name = "Taste"  value = "5"  /> 苦
<input type = "checkbox"  name = "Taste"  value = "7"  /> 辣 
<input type = "checkbox"  name = "Taste"  value = "11"  /> 咸 
<input type = "checkbox"  name = "Taste"  value = "13"  /> 淡
<input type = "checkbox"  name = "Taste"  value = "17"  /> 麻  
<input type = "checkbox"  name = "Taste"  value = "19"  /> 鲜 
<input type = "hidden"  name = "allTaste"  value = ""  />
<input type = "hidden"  name = "allTasteInC"  value = ""  />
</p>

<b>菜系: </b>
<select name="Style">
	<option value = "1">鲁菜</option>
	<option value = "2">川菜</option>
	<option value = "3">苏菜</option>
	<option value = "4">粤菜</option>
	<option value = "5">浙菜</option>
	<option value = "6">闽菜</option>
	<option value = "7">湘菜</option>
	<option value = "8">徽菜</option>
	<option value = "9">东北菜</option>
	<option value = "10">其他</option>
</select>


<p>
<b>食堂: </b>
<input type = "radio"  name = "Canteen"  value = "2"  checked = "checked"/> 学一
<input type = "radio"  name = "Canteen"  value = "3"  /> 学五
<input type = "radio"  name = "Canteen"  value = "5"  /> 艺园
<input type = "radio"  name = "Canteen"  value = "7"  /> 家园
<input type = "radio"  name = "Canteen"  value = "11"  /> 农园
<input type = "radio"  name = "Canteen"  value = "13"  /> 燕南
<input type = "radio"  name = "Canteen"  value = "17"  /> 康博思
<input type = "radio"  name = "Canteen"  value = "19"  /> 佟园
</p>

<p>
<input type = "submit"  value = "确定" />
<input type = "reset"  value = "重置" />
</p>
<?php
	echo "<input type=\"hidden\" name=\"user\" value=\"".$useername."\" />";
?>

</form>

<hr />
</body>
</html>
