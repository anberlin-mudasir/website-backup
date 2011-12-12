<?xml version = "1.0" encoding = "utf-8" encoding="utf-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns = "http://www.w3.org/1999/xhtml">
	<head> 
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>管理收藏</title> 
	<style>
		body 
		{
			background-image:url(../../image/deleteDish_back.jpg);
			text-align:center;
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
<?php include('common_userinfo.php') ?>
<script language="javascript">
    function submitFormShow(i){ 
        this.document.myForm.action = "./showChooseDish.php"; 
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
    function del(name)
    {
        if (check()==false)
            return;
		var q = document.getElementsByName("deleteNumber[]");
        var req="name="+name;
        for (var i=0; i<q.length; i++)
            if (q[i].checked==true)
                req+="&deleteNumber[]="+q[i].value;

        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp=new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }

        xmlhttp.onreadystatechange=function() {
            if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
                if (xmlhttp.responseText=="succeed")
                {
                    alert('删除成功！');
                    document.getElementById('refresh').submit();
                }
            }
        }
        xmlhttp.open("POST","mark_delete.php",true);
        xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xmlhttp.send(req);
    }
</script> 


<div><h2>北京大学餐饮信息查询系统</h2></div>

<?php
    echo "<form  id=\"back\" action=\"./User_log.php\" method=\"post\" style=\"color:#00F\">";
	echo "<input type=\"hidden\" name=\"useername\" value=\"".$useername."\" />";
	echo "<input type=\"hidden\" name=\"password\" value=\"".$password."\" />";
	echo "<input type=\"hidden\" name=\"test\" value=\"false\" />";
    echo "<div onclick=\"document.getElementById('back').submit();\" style=\"cursor:hand;\"><a href=\"#\"><p>返回面板<br /></p></a></div></form>";
?>


<?php
//connect to MySql
$db = mysql_connect("","se","se");
mysql_select_db('meal',$db);
//用户验证
$useername=$_POST['useername'];
$query='select * from user where name=\"'.$useername.'\"';
$query=stripslashes($query);
$result=mysql_query($query,$db);
$num=mysql_num_rows($result);
if($num==0)
	echo "<script>window.alert(\"请先登录\");window.location='../../Admin/Admin_log.html';</script>";

$query = 'select dishes.Number Number,Name,Price,Taste,Ingredients,Canteen,Style,Grade,Description,Url_of_image from (dishes join mark on dishes.Number=mark.Number) where User="'.$useername.'"';
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

echo '<form action = "javascript:del(\''.$useername.'\')"  name = "myForm"  method = "post" id ="contents">';
echo '<table border = "border">';
echo '<tr><th>菜名</th><th>图片</th><th>删除</th></tr>';
$query = 'select dishes.Number Number,Name,Price,Taste,Ingredients,Canteen,Style,Grade,Description,Url_of_image from (dishes join mark on dishes.Number=mark.Number) where User="'.$useername.'" limit '.$kai.','. $limit;
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
echo "<input type=\"hidden\" name=\"useername\" value=\"".$useername."\" />";  //用户名
echo '<input type = "hidden" name = "Number" value = "-1">'; 
//echo '<input type = "submit"  value = "删除" onClick= "return check();"/>';
echo '<input type = "submit"  value = "删除" />';
echo '</form>';
echo '<br/><br/>';

echo "<table style=\"text-align:center; margin-left:auto; margin-right:auto; font-size:20px; color:#00F;\"><tr>";
$count_i=0;
$count_j=1;
$current=$kai/5+1;
//显示上一页
echo "<td onclick=\"document.getElementById('pre').submit();\" style=\"cursor:hand;\" >\n";
echo "<form id=\"pre\" action=\"showMark.php\" method=\"post\">\n";
$current0=($current-2)*$limit;
echo "<input type=\"hidden\" name=\"start\" value=\"".$current0."\" />";
echo "<input type=\"hidden\" name=\"useername\" value=\"".$useername."\" />";
echo "<input type=\"hidden\" name=\"password\" value=\"".$password."\" />";
echo "<input type=\"submit\" value=\"上一页\" />&nbsp;&nbsp;";
echo "</form></td>";
while($count_i<$totalnum)
{
	if($current!=$count_j)
		echo "<td onclick=\"document.getElementById('".$count_j."').submit();\" style=\"cursor:hand;\" >\n";
	else
		echo "<td onclick=\"document.getElementById('".$count_j."').submit();\" style=\"cursor:hand;color:#F0F\" >\n";
	echo "<form id=\"".$count_j."\" action=\"showMark.php\" method=\"post\">\n";
	echo "<input type=\"hidden\" name=\"start\" value=\"".$count_i."\" />";
	echo "<input type=\"hidden\" name=\"useername\" value=\"".$useername."\" />";
    echo "<input type=\"hidden\" name=\"password\" value=\"".$password."\" />";
	echo "</form>&nbsp;&nbsp;".$count_j."</td>";
	$count_j++;
	$count_i+=$limit;
}
//显示下一页
echo "<td onclick=\"document.getElementById('next').submit();\" style=\"cursor:hand;\" >\n";
echo "<form id=\"next\" action=\"showMark.php\" method=\"post\">\n";
$current=$current*$limit;
echo "<input type=\"hidden\" name=\"start\" value=\"".$current."\" />";
echo "<input type=\"hidden\" name=\"useername\" value=\"".$useername."\" />";
echo "<input type=\"hidden\" name=\"password\" value=\"".$password."\" />";
echo "&nbsp;&nbsp;<input type=\"submit\" value=\"下一页\" />";
echo "</form></td>";
echo "</tr></table>";


echo "<form id=\"refresh\" action=\"showMark.php\" method=\"post\">";
echo "<input type=\"hidden\" name=\"start\" value=0 />";
echo "<input type=\"hidden\" name=\"useername\" value=\"".$useername."\" />";
echo "<input type=\"hidden\" name=\"password\" value=\"".$password."\" />";
echo "</form>";
?>


<br/>

<br/>
<hr/>

</body>
</html>
