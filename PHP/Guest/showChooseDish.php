<?xml version = "1.0" encoding = "utf-8" encoding="utf-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns = "http://www.w3.org/1999/xhtml">
	<head> 
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>菜肴</title> 
			<style>
	body {
		background-image:url(../../image/showChooseDish_back.jpg);
		
	}
	table {
		margin-left:auto;
		margin-right:auto;
	}
	a:visited
	{	
		color:#00F;
	}
    </style>
<script type="text/javascript">
function mark(name,num)
{
    var req="name="+name+"&number="+num;
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
                alert('收藏成功!');
                document.getElementById('mark_button').value="您已收藏";
                document.getElementById('mark_button').disabled="disabled";
            }
        }
    }
    xmlhttp.open("POST","mark_append.php",true);
    xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xmlhttp.send(req);
}
</script>
</head>

<body>
<?php include('common_userinfo.php') ?>
<div style="text-align:center;">
    <h2 style=" filter:glow(color=#FF0,strength=5);font-size:38px; font-family:STXinwei,STXingkai,SimHei;">北京大学餐饮信息查询系统</h2>
    </div>
        <form id="form1" action="./showAllDishes.php" method="post">
	<input type="hidden" name="start" value="0" />
<?php
	echo "<input type=\"hidden\" name=\"useername\" value=\"".$useername."\" />";
	echo "<input type=\"hidden\" name=\"password\" value=\"".$password."\" />";
?>
	</form>
<div onclick="document.getElementById('form1').submit();" style="cursor:hand; color:#00F;text-align:right;font-size:24px;">返回菜肴列表</div>
<br/>
<hr/>


<form action = "./opinion.php" method = "post">
<?php
//connect to MySql
$db = mysql_connect("","se","se");
mysql_select_db('meal',$db);

$Number = $_POST['Number'];

$query = 'select * from dishes where Number = '.$Number;
$result = mysql_query($query,$db);

$style = array("鲁菜","川菜","苏菜","粤菜","浙菜","闽菜","湘菜","徽菜","东北菜","其他");

$prime = array(2,3,5,7,11,13,17,19);
$primenum = array(0,1,0,1,4,2,6,3,8,9,10,4,12,5,14,15,16,6,18,7,20);
$canteenarr = array("学一","学五","艺园","家园","农园","燕南","康博思","佟园");
$tastearr = array("酸","甜","苦","辣","咸","淡","麻","鲜");



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

    if ($useername!="guest")
    {
        echo '<tr>';
        echo '<td></td>';
        echo '<td style="text-align:center"><input id="mark_button" ';

        $query2 = 'select * from mark where User="'.$useername.'" and Number='.$Number;
        $result2 = mysql_query($query2,$db);
        $num=mysql_num_rows($result2);
        if ($num!=0)
        {
            echo 'type="button" value="您已收藏" ';
            echo 'disabled="disabled"';
        }
        else
        {
            echo 'type="button" value="加入收藏" ';
            echo 'onclick="javascript:mark(\''.$useername.'\','.$Number.')" ';
        }
        echo '/></td>';
        echo '</tr>';
    }
}
echo '</table>';
//展示评论
echo '<br/><br/><br/><h3 style="text-align:left;font-family:verdana;color:blue">用户评论</h3>';

if(NULL != $Opinion_table_name)
{
	$query = 'select * from '.$Opinion_table_name;
	$result = mysql_query($query,$db);
	$count = 1;
	echo '<hr/>';
	while($row2 = mysql_fetch_array($result))
	{
		extract($row2);
		echo '<p><h4 style = "color:blue">'.$count.'.'.$Time.'</h4>';
		echo "<b>".$User."</b> 说：".$Opinion;
		echo '</p>';
		echo '<hr/>';
		$count ++;
	}
}
echo '<input type = "hidden" name = Dish_number value = "'.$Number.'" >';
echo "<input type=\"hidden\" name=\"useername\" value=\"".$useername."\" />";
echo "<input type=\"hidden\" name=\"password\" value=\"".$password."\" />";

?>


<h4>评分: </h4>
<p>
<input type = "radio"  name = "Grade"  value = "1"  /> 1
<input type = "radio"  name = "Grade"  value = "2"  /> 2
<input type = "radio"  name = "Grade"  value = "3"  /> 3
<input type = "radio"  name = "Grade"  value = "4"  /> 4
<input type = "radio"  name = "Grade"  value = "5"  checked = "checked"/> 5
</p>

<h4>评论:</h4>
<p>
<textarea name="Opinion" rows="15" cols = "60">
</textarea>
</p>
<br/>

<p>
<input type = "submit"  value = "提交" />
</p>
</form>

<br/>
<hr/>

</body>
</html>
