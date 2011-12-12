
<?xml version = "1.0" encoding = "utf-8" encoding="utf-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns = "http://www.w3.org/1999/xhtml">
	<head> 
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>高级检索</title> 
		<style>
		body {
		background-image:url(../../image/searchDish_back.jpg);
		text-align:center;
	}
	
	</style>
	</head> 
	

<body>
<?php include('common_userinfo.php') ?>
<div style="padding:25px">
    <h2 style=" filter:glow(color=#FF0,strength=5);font-size:38px; font-family:STXinwei,STXingkai,SimHei;">北京大学餐饮信息查询系统</h2>
    </div>

	<form id="form1" action="./showAllDishes.php" method="post">
	<input type="hidden" name="start" value="0" />
<?php
	echo "<input type=\"hidden\" name=\"useername\" value=\"".$useername."\" />";
	echo "<input type=\"hidden\" name=\"password\" value=\"".$password."\" />";
    echo "<div onclick=\"document.getElementById('form1').submit();\" style=\"cursor:hand;\"><a href=\"#\"><p>返回<br /></p></a></div></form>";
?>
	</form>

<br/>
<hr/>


<script language="javascript">
   <!--    
	function checkSubmit(){
		var q = document.getElementById("contents");
		var bok = false;
		var i,j;
	//	window.alert("开始");
		if(q.Name.value == "" && q.Ingredients.value == "")
		{}
		else{bok=true;}
		
		q.allTaste.value = "";
		for(i = 0;i <= 7;i ++){
			if(q.Taste[i].checked){
				q.allTaste.value += q.Taste[i].value;
				bok = true;
				for(j = i +1;j <= 7;j ++){
					if(q.Taste[j].checked){
					q.allTaste.value += ' ';
					q.allTaste.value += q.Taste[j].value;
					}
				}
				break;
			}
		}
	//	window.alert(q.allTaste.value);
		
		q.allStyle.value = 0;
		for(i = 0;i <= 9;i ++){
			if(q.Style[i].checked){
				q.allStyle.value = q.Style[i].value;
				bok = true;
				break;
			}
		}
	//	window.alert(q.Style.value);
		
		q.allCanteen.value = "";
		for(i = 0;i <= 7;i ++){
			if(q.Canteen[i].checked){
				q.allCanteen.value += q.Canteen[i].value;
				bok = true;
				for(j = i +1;j <= 7;j ++){
					if(q.Canteen[j].checked){
					q.allCanteen.value += ' ';
					q.allCanteen.value += q.Canteen[j].value;
					}
				}
				break;
			}
		}
	//	window.alert(q.Canteen.value);
		
		if(false == bok)
		{
			window.alert("检索内容不能为空");
			q.Name.focus();
			return false; 
		}
	 ////////////////////////////////////////
    return true;
   } // checkSubmit
   
   -->
</script>

<form action = "./doSearch.php" onSubmit="return checkSubmit();" method = "post" id="contents">
<p/>
	<h3 style="text-align:center">请根据您的自身需要填写检索项</h3>
<p/>

<h4>名字:<input type="text" name="Name" /></h4> 
<h4>原料:<input type="text" name="Ingredients" /></h4>
<p>如果有多种原料，以空格分开</p>

<h4>口味: </h4>
<p>
<input type = "checkbox"  name = "Taste"  value = "2"  /> 酸
<input type = "checkbox"  name = "Taste"  value = "3"  /> 甜 
<input type = "checkbox"  name = "Taste"  value = "5"  /> 苦
<input type = "checkbox"  name = "Taste"  value = "7"  /> 辣 
<input type = "checkbox"  name = "Taste"  value = "11"  /> 咸 
<input type = "checkbox"  name = "Taste"  value = "13"  /> 淡
<input type = "checkbox"  name = "Taste"  value = "17"  /> 麻  
<input type = "checkbox"  name = "Taste"  value = "19"  /> 鲜 
<input type = "hidden"  name = "allTaste"  value = ""  />
</p>

<h4>菜系: </h4>
<p>
<input type = "radio"  name = "Style"  value = "1"  /> 鲁菜
<input type = "radio"  name = "Style"  value = "2"  /> 川菜
<input type = "radio"  name = "Style"  value = "3"  /> 苏菜
<input type = "radio"  name = "Style"  value = "4"  /> 粤菜
<input type = "radio"  name = "Style"  value = "5"  /> 浙菜
<input type = "radio"  name = "Style"  value = "6"  /> 闽菜
<input type = "radio"  name = "Style"  value = "7"  /> 湘菜
<input type = "radio"  name = "Style"  value = "8"  /> 徽菜
<input type = "radio"  name = "Style"  value = "9"  /> 东北菜
<input type = "radio"  name = "Style"  value = "10" /> 其他
<input type = "hidden"  name = "allStyle"  value = "" />
</p>

<h4>食堂: </h4>
<p>
<input type = "checkbox"  name = "Canteen"  value = "2"  /> 学一
<input type = "checkbox"  name = "Canteen"  value = "3"  /> 学五
<input type = "checkbox"  name = "Canteen"  value = "5"  /> 艺园
<input type = "checkbox"  name = "Canteen"  value = "7"  /> 家园
<input type = "checkbox"  name = "Canteen"  value = "11"  /> 农园
<input type = "checkbox"  name = "Canteen"  value = "13"  /> 燕南
<input type = "checkbox"  name = "Canteen"  value = "17"  /> 康博思
<input type = "checkbox"  name = "Canteen"  value = "19"  /> 佟园
<input type = "hidden"  name = "allCanteen"  value = "" />
</p>


<p>
<input type = "submit"  value = "确定" />
<input type = "reset"  value = "重置" />
</p>
<?php
	echo "<input type=\"hidden\" name=\"useername\" value=\"".$useername."\" />";
    echo "<input type=\"hidden\" name=\"password\" value=\"".$password."\" />";
?>
</form>

<hr />
</body>
</html>
