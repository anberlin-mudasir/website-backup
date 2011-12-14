<?xml version = "1.0" encoding = "utf-8" encoding="utf-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns = "http://www.w3.org/1999/xhtml">
<head> 
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>管理收藏</title> 
  <link href="../../css/base.css" type="text/css" rel="stylesheet"/>
  <link href="../../css/login.css" type="text/css" rel="stylesheet"/>
  <link href="../../css/user.css" type="text/css" rel="stylesheet"/>
  <link href="../../css/shop-min.css" type="text/css" rel="stylesheet"/>
  <script language="javascript">
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
        xmlhttp.open("POST","User_mark_delete.php",true);
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
<?php
$db = mysql_connect("","se","se");
mysql_select_db('meal',$db);
$useername=$_POST['useername'];
$query='select * from user where name=\"'.$useername.'\"';
$query=stripslashes($query);
$result=mysql_query($query,$db);
$num=mysql_num_rows($result);
if($num==0)
    echo "<script>window.alert(\"请先登录\");window.location='../../Admin/Admin_log.html';</script>";
?>


<?php
$query = 'select dishes.Number Number,Name,Price,Taste,Ingredients,Canteen,Style,Grade,Description,Url_of_image from (dishes join mark on dishes.Number=mark.Number) where User="'.$useername.'"';
$result = mysql_query($query,$db);
$totalnum=mysql_num_rows($result);
if (isset($_POST['start']))
    $kai=$_POST['start'];
else
    $kai=0;
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
$query = 'select dishes.Number Number,Name,Price,Taste,Ingredients,Canteen,Style,Grade,Description,Url_of_image from (dishes join mark on dishes.Number=mark.Number) where User="'.$useername.'" limit '.$kai.','. $limit;
$query=stripslashes($query);
$result = mysql_query($query,$db);
$num=mysql_num_rows($result);
?>

<div class="main_w">
  <br />
  <div class="content_n">
    <div class="memberBox">
      <div class="box feedBox">
        <div class="feedTip"><p>亲，你的口味集合哦!</p></div>
      </div>
      <h3>收藏管理
<?php
if ($num!=0)
{
?>
        <div class="min-del-box">
          <a class="min-del" href="javascript:del('<?php echo $useername; ?>')">
            取消选中的收蔵</a>
        </div>
<?php
}
?>
      </h3>
    </div>
<?php
if ($num==0)
    echo '您还未收藏菜肴!';

while($row = mysql_fetch_assoc($result))
{
    extract($row);
?>
    <div class="feedList">
      <table class="min-table">
      <tr>
        <td rowspan="4">
        <form action="./User_showdish.php" method="post">
        <?php include('common_post.php');?>
<?php
    echo '<input width="249" type="image" height="168" alt="" src="../../image/'.$Url_of_image.'"/>';
	echo '<input type="hidden" name="Number" value="'.$Number.'"/>';
?>
        </form>
        </td>
        <td>
          <strong><?php echo $Name; ?></strong>
      </td>
      </tr>
      <tr><td><p>价格: 
        <span class="min-price">¥<?php echo $Price; ?></span></p></td></tr>
      <tr><td><p>评分: 
        <span class="min-score"> <?php echo round($Grade,2); ?> </span></p></td></tr>
      <tr><td>
        <div class="min-del-pick">
        <input type="checkbox" value="<?php echo $Number?>" name="deleteNumber[]"/>
         <span class="min-del">取消收藏</span>
        </div>
      </td></tr>
      </table>
    </div>
<?php
}
?>
<?php
if ($num!=0)
{
?>
    <div class="Pages">
<?php
$count_i=0;
$count_j=1;
$current=$kai/5+1;
$current0=($current-2)*$limit;
?>
<!--prev page -->
    <a class="PrevPage" title="上一页" href="javascript:document.pre.submit();">上一页</a>
    <form name="pre" class="Hide" action="#" method="post">
<?php
    echo '<input type="hidden" name="start" value="'.$current0.'"/>';
    include('common_post.php');
?>
    </form>
<!--num iteration -->
<?php
while($count_i<$totalnum)
{
    if($current!=$count_j)
        echo '<a class="PageLink" href="javascript:document.getElementById(\'page_'.$count_j.'\').submit();">'.$count_j.'</a>';
    else
        echo '<span class="PageSel" href="javascript:document.getElementById(\'page_'.$count_j.'\').submit();">'.$count_j.'</span>';
    echo '<form id="page_'.$count_j.'" class="Hide" action="#" method="post">';
    echo '<input type="hidden" name="start" value="'.$count_i.'"/>';
    include('common_post.php');
    echo '</form>';
    $count_j++;
    $count_i+=$limit;
}
?>


<!--next page -->
    <a class="NextPage" title="下一页" href="javascript:document.next.submit();">下一页</a>
    <form name="next" class="Hide" action="#" method="post">
<?php
    echo '<input type="hidden" name="start" value="'.($current*$limit).'"/>';
    include('common_post.php');
?>
    </form>
    </div> <!--div Pages-->
<?php
}
?>
  </div>

<!--  tool box -->
  <div class="asider_n">
    <div class="box tools">
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
</div>



<form id="refresh" action="#" method="post"/>
  <input type="hidden" name="start" value="0" />
  <?php include('common_post.php');?>
</form>

</body>
</html>
