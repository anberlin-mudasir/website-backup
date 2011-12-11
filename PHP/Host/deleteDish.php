<?xml version = "1.0" encoding = "utf-8" encoding="utf-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns = "http://www.w3.org/1999/xhtml">
	<head> 
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>删改菜肴</title> 
	<style>
		body 
		{
			background-image:url(../../image/deleteDish_back.jpg);
			text-align:center;
		}
		h1 
		{
			filter:glow(color=#FF0,strength=5);
			font-size:38px; 
			font-family:STXinwei,STXingkai,SimHei;
		}
	table {
		background-color:#FCF;
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

<script language="javascript">
    function submitFormShow(i){ 
        this.document.myForm.action = "./showIt.php"; 
		var q = document.getElementById("contents");
		q.Number.value = i;
		return true; 
    } 
	function check(){
		var i;
		var bok = false;
		var q = document.getElementsByName("deleteNumber[]");
		var qq = document.getElementById("contents");
		var length = q.length;
		for(i=0;i < length;i++){
		     if(q[i].checked == true)
				bok = true;
		}
		if(false == bok){
			window.alert("没有删除项");
			return false;
		}
        return true; 
		
    } 
</script> 


<div><h1>北京大学餐饮信息查询系统</h1></div>



<?php
//connect to MySql
$db = mysql_connect("","se","se");
mysql_select_db('meal',$db);
//用户验证
$useername=$_POST['user'];
$query='select * from admin where name=\"'.$useername.'\"';
$query=stripslashes($query);
$result=mysql_query($query,$db);
$num=mysql_num_rows($result);
if($num==0)
	echo "<script>window.alert(\"请先登录\");window.location='../../Admin/Admin_log.html';</script>";
else
{
	echo "<table style=\"text-align:right; margin-right:50px; font-size:20px;\" ><tr><td>";
	echo "<div style=\"color:#039\">欢迎".$useername."</div></td";
	echo "<td><form  id=\"return\" action=\"./Admin_log.php\" method=\"post\" style=\"color:#039\">";
	echo "<input type=\"hidden\" name=\"test\" value=\"true\" />";
	echo "<input type=\"hidden\" name=\"uesername\" value=\"".$useername."\" />";
	echo "<input type=\"hidden\" name=\"password\" value=\"\" />";
	echo "<div onclick=\"document.getElementById('return').submit();\" style=\"cursor:hand;\">&nbsp;&nbsp;返回</div></form>";
	echo "</td></tr></table>";
}

$query = 'select * from dishes';
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

echo '<form action = "./doDelete.php"  name = "myForm"  method = "post" id ="contents">';
echo '<table border = "border">';
echo '<tr><th>菜名</th><th>图片</th><th>删除</th></tr>';
$query = 'select * from dishes limit '.$kai.','. $limit;
$query=stripslashes($query);
$result = mysql_query($query,$db);
while($row = mysql_fetch_assoc($result))
{
	extract($row);
	echo '<tr>';
	echo '<th>'.$Name.'</th>';
	echo '<th >';
	echo '<input type = "image" src = "../../image/'.$Url_of_image.'" alt = ""  width="249" height="168" onClick= "return submitFormShow('.$Number.');"/>';
	echo '</th><th>';
	echo '<input type = "checkbox" name = "deleteNumber[]" value = "'.$Number.'">';
	echo '</th>';
	echo '</tr>';
}
echo '</table>';
echo '<br/><br/>';
echo "<input type=\"hidden\" name=\"user\" value=\"".$useername."\" />";  //用户名
echo '<input type = "hidden" name = "Number" value = "-1">'; 
echo '<input type = "submit"  value = "删除" onClick= "return check();"/>';
echo '</form>';
echo '<br/><br/>';

echo "<table style=\"text-align:center; margin-left:auto; margin-right:auto; font-size:20px; color:#00F;\"><tr>";
$count_i=0;
$count_j=1;
$current=$kai/5+1;
//显示上一页
echo "<td onclick=\"document.getElementById('pre').submit();\" style=\"cursor:hand;\" >\n";
echo "<form id=\"pre\" action=\"deleteDish.php\" method=\"post\">\n";
$current0=($current-2)*$limit;
echo "<input type=\"hidden\" name=\"start\" value=\"".$current0."\" />"; //页数
echo "<input type=\"hidden\" name=\"user\" value=\"".$useername."\" />"; //用户名
echo "<input type=\"submit\" value=\"上一页\" />&nbsp;&nbsp;";
echo "</form></td>";
while($count_i<$totalnum)
{
	if($current!=$count_j)
		echo "<td onclick=\"document.getElementById('".$count_j."').submit();\" style=\"cursor:hand;\" >\n";
	else
		echo "<td onclick=\"document.getElementById('".$count_j."').submit();\" style=\"cursor:hand;color:#F0F\" >\n";
	echo "<form id=\"".$count_j."\" action=\"deleteDish.php\" method=\"post\">\n";
	echo "<input type=\"hidden\" name=\"start\" value=\"".$count_i."\" />";
	echo "<input type=\"hidden\" name=\"user\" value=\"".$useername."\" />"; //用户名
	echo "</form>&nbsp;&nbsp;".$count_j."</td>";
	$count_j++;
	$count_i+=$limit;
}
//显示下一页
echo "<td onclick=\"document.getElementById('next').submit();\" style=\"cursor:hand;\" >\n";
echo "<form id=\"next\" action=\"deleteDish.php\" method=\"post\">\n";
$current=$current*$limit;
echo "<input type=\"hidden\" name=\"start\" value=\"".$current."\" />";
echo "<input type=\"hidden\" name=\"user\" value=\"".$useername."\" />"; //用户名
echo "&nbsp;&nbsp;<input type=\"submit\" value=\"下一页\" />";
echo "</form></td>";
echo "</tr></table>";
?>

<br/>

<br/>
<hr/>

</body>
</html>
