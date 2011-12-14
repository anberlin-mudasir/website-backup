<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns = "http://www.w3.org/1999/xhtml">
<head> 
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>菜肴信息</title> 
  <link href="../../css/base.css" type="text/css" rel="stylesheet"/>
  <link href="../../css/login.css" type="text/css" rel="stylesheet"/>
  <link href="../../css/user.css" type="text/css" rel="stylesheet"/>
  <link href="../../css/shop-min.css" type="text/css" rel="stylesheet"/>
  <script type="text/javascript">
    function checkSubmit3()
    {
        var comment=document.contents.Opinion;
        var grade=document.contents.Grade;
        var val=-1;
        for(var i = 0; i < grade.length; i++ )
        {
            if(grade[i].checked==true)
                val=grade[i].value;
        }
        if(val < 0)
        {
            alert("给个评分哦亲");
            return false;
        }
        if (comment.value=="")
        {
            alert("评论不能为空");
            return false;
        }
        return true;
    }
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
                    document.getElementById('mark').style.display="none";
                    document.getElementById('marked').style.display="block";
                    alert('收藏成功!');
                }
            }
        }
        xmlhttp.open("POST","User_mark_append.php",true);
        xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xmlhttp.send(req);
    }
  </script>
</head>

<body>
<?php include('common_userinfo.php') ?>
<?php
    if ($useername!="guest")
        include('header_user.php');
    else
        include('header_guest.php');
?>



<div class="main_w">
  <br />
  <div class="content_n">
    <div class="memberBox">
<?php
if ($useername!='guest')
{
?>
      <div class="box feedBox">
        <div class="feedTip"><p>点击按钮收藏下它吧!</p></div>
      </div>
<?php
}
?>
      <h3>菜肴信息</h3>
    </div>

<?php
if (isset($_POST['Number']))
{
    $Number = $_POST['Number'];
}
else
    die('<meta http-equiv="refresh" content="1;URL=../../index.html">出错了，返回首页！');

$style = array("鲁菜","川菜","苏菜","粤菜","浙菜","闽菜","湘菜","徽菜","东北菜","其他");
$prime = array(2,3,5,7,11,13,17,19);
$primenum = array(0,1,0,1,4,2,6,3,8,9,10,4,12,5,14,15,16,6,18,7,20);
$canteenarr = array("学一","学五","艺园","家园","农园","燕南","康博思","佟园");
$tastearr = array("酸","甜","苦","辣","咸","淡","麻","鲜");

include('mysql_db.php');

$query = 'select * from dishes where Number = '.$Number;
$result = mysql_query($query,$db);
$row = mysql_fetch_array($result);
extract($row);
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
?>

    <div class="feedList">
      <table class="min-table">
      <tr>
      <td rowspan="6"><input width="249" type="image" height="168" alt="" src="../../image/<?php echo $Url_of_image; ?>"/></td>
        <td><strong><?php echo $Name; ?></strong>
<?php
if ($useername!="guest")
{
?>
        <div class="min-mark-box" id="mark_button">
<?php
    $query2 = 'select * from mark where User="'.$useername.'" and Number='.$Number;
    $result2 = mysql_query($query2,$db);
    $num=mysql_num_rows($result2);
    if ($num==0)
    {
?>
          <span id="mark" class="btn-type-a btn-fn-a">
          <a class="form-btn min-mark" href="javascript:mark('<?php echo $useername."',".$Number?>)">收藏</a>
          </span>
          <span id="marked" class="btn-type-a btn-fn-b" style="display:none">
            <a class="form-btn min-marked">已收藏</a>
          </span>
<?php
    }
    else
    {
?>
          <span id="mark" class="btn-type-a btn-fn-a" style="display:none">
          <a class="form-btn min-mark" href="javascript:mark('<?php echo $useername."',".$Number?>)">收藏</a>
          </span>
          <span id="marked" class="btn-type-a btn-fn-b">
            <a class="form-btn min-marked">已收藏</a>
          </span>
<?php
    }
?>
        </div>
<?php
}
?>
        </td>
      </tr>
      <tr><td>
      <span>食堂: <span class="min-canteen"><?php echo $canteenarr[$primenum[$Canteen]];?></span></span>
      <span>价格: <span class="min-price">¥<?php echo $Price;?></span></span>
      <span>评分: <span class="min-score"><?php echo round($Grade,2)?></span></span>
      </td></tr>
      <tr><td><span>食料: <?php echo $Ingredients; ?></span></td></tr>
      <tr><td><span>菜系: <?php echo $style[$Style-1]; ?></span></td></tr>
      <tr><td><span>口感: <?php echo $allTaste; ?></span></td></tr>
      <tr><td><span class="min-des"><?php echo $Description; ?></span></td></tr>
      </table>
    </div>
  </div>

<!--Tool box-->
  <div class="asider_n">
    <div class="box tools">
<?php
if ($useername!='guest')
{
?>
      <p>
        <form name="mark" action="./User_showmark.php" method="post">
        <?php include('common_post.php');?>
        </form>
        <span class="item itoolsFavorite">
          <a class="B" href="javascript:document.mark.submit()">查看收藏</a>
        </span>
      </p>
<?php
}
?>
      <p>
        <form name="back" action="./User_log.php" method="post">
        <?php include('common_post.php');?>
        </form>
        <span class="item itoolsStyle">
          <a class="B" href="javascript:document.back.submit()">返回主面板</a>
        </span>
      </p>
    </div>
  </div>


<!--User comment -->
  <div class="content_n">
  <br />
    <div class="memberBox">
<?php
$num=0;
if(NULL != $Opinion_table_name)
{
	$query = 'select * from '.$Opinion_table_name;
    $result = mysql_query($query,$db);
    $num=mysql_num_rows($result);
?>
    <h3>用户评论共<?php echo $num;?>条</h3>
<?php
	while($row2 = mysql_fetch_array($result))
	{
		extract($row2);
?>
    <div class="feedList">
      <ul><li>
      <span class="time"><?php echo $Time;?></span>
        <?php echo $User ?>说：<?php echo $Opinion; ?>
      </li></ul>
    </div>
<?php
    }
}
else
{
?>
    <h3>没有用户作出过评论</h3>
  </div>
<?php
}
?>
  <div class="content_n">
  <br />
    <div class="memberBox">
      <h3>我也来点评几句!</h3>
    </div>
    <div class="feedList">
      <div class="form-block">
        <form id="contents" name="contents" method="post" action="./User_comment_result.php">
        <p class="min-gray">评分: </p>
            <input type="radio" value="1" name="Grade"/>1
            <input type="radio" value="2" name="Grade"/>2 
            <input type="radio" value="3" name="Grade"/>3
            <input type="radio" value="4" name="Grade"/>4 
            <input type="radio" value="5" name="Grade"/>5
        <p class="min-gray">评论: </p>
        <textarea id="comment" class="form-textarea focus"cols="60" rows="15" name="Opinion"></textarea><br/>
        <?php include('common_post.php');?>
        <input type="hidden" name="Number" value="<?php echo $Number;?>"/>
        </form>
      </div>
      <span class="btn-type-a btn-fn-a">
        <a class="form-btn" href="javascript:if(checkSubmit3())document.getElementById('contents').submit()">发布</a>
      </span>
    </div>
  </div>
</div>


<form id="refresh" action="#" method="post"/>
  <input type="hidden" name="Number" value="<?php echo $Number;?>" />
  <?php include('common_post.php');?>
</form>

</body>
</html>
