<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns = "http://www.w3.org/1999/xhtml">
<head> 
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>修改菜肴</title> 
  <link href="../../css/base.css" type="text/css" rel="stylesheet"/>
  <link href="../../css/login.css" type="text/css" rel="stylesheet"/>
  <link href="../../css/user.css" type="text/css" rel="stylesheet"/>
  <link href="../../css/shop-min.css" type="text/css" rel="stylesheet"/>
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
</head> 
<body>
<?php include('common_admininfo.php'); ?>
<?php
include('mysql_db.php');
$query='select * from admin where name="'.$useername.'" and pass="'.$password.'"';
$query=stripslashes($query);
$result=mysql_query($query);
$num=mysql_num_rows($result);
if($num==0)
{
    echo "<script>window.alert(\"请先登录\");window.location='../../index.html';</script>";
    die('');
}
?>

<?php include('header_admin.php');?>
<?php
$stylearr = array("鲁菜","川菜","苏菜","粤菜","浙菜","闽菜","湘菜","徽菜","东北菜","其他菜");
$primenum = array(0,1,0,1,4,2,6,3,8,9,10,4,12,5,14,15,16,6,18,7,20);
$canteenarr = array("学一","学五","艺园","家园","农园","燕南","康博思","佟园");
$prime = array(2,3,5,7,11,13,17,19);
$tastearr = array("酸","甜","苦","辣","咸","淡","麻","鲜");
?>
<div class="main_w">
  <br />
  <div class="content_n">
    <div class="memberBox">
      <h3>添加菜肴
      </h3>
    </div>
<?php
$number = $_POST['modify'];
$query = 'select * from dishes where Number = '.$number;
$result = mysql_query($query,$db);
$num=mysql_num_rows($result);
if ($num==0)
    die('读取菜肴信息出错');

if($row = mysql_fetch_array($result)){
	extract($row);
}
?>
    <div class="feedList">
      <div class="section">
        <div id="cont-reg" class="block login-form">
          <div class="pop-win-inner">
            <form id="contents" enctype="multipart/form-data" method="post" action="Admin_update_dish_do.php">
              <?php include('common_post.php');?>
              <input type="hidden" name="Number" value="<?php echo $Number?>"/>

              <div class="form-block">
                <label class="label" for="name">名字：</label>
                <input name="Name" id="name" class="form-default" type="text" value="<?php echo $Name;?>"/>

              </div>
              <div class="form-block">
                <label class="label" for="ingredient">原料：</label>
                <input name="Ingredients" id="ingredient" class="form-default" type="text" value="<?php echo $Ingredients;?>"/>
              </div>
              <div class="form-block">
                <label class="label" for="price">价格：</label>
                <input name="Price" id="price" class="form-default" type="text" value="<?php echo $Price;?>"/>
              </div>
              <div class="form-block">
                <label class="label" for="picture">图片：</label>
                <input name="Url_of_image" id="picture" class="form-default" type="file" value="<?php echo $Url_of_image; ?>"/>
              </div>

              <div class="form-block">
                <label class="label" for="description">描述：</label>
                <textarea rows="4" name="Description" id="description" class="form-default"><?php echo $Description;?></textarea>
              </div>
              <div class="form-block">
                <label class="label" for="taste">口味：</label>
                <div>
<?php
for ($i=0; $i<=7; $i++)
{
	if($Taste % $prime[$i] == 0)
        echo '<input type="checkbox" name="Taste" value="'.$prime[$i].'" checked="checked"/>'.$tastearr[$i];
    else
        echo '<input type="checkbox" name="Taste" value="'.$prime[$i].'"/>'.$tastearr[$i];
}
?>
             <input type="hidden" name="allTaste" value=""/>
             <input type="hidden" name="allTasteInC" value=""/>
                </div>
              </div>
              <div class="form-block">
                <label class="label" for="style">菜系：</label>
<?php
for($i=0; $i<=9; $i++)
{
	if($Style==($i+1))
		echo '<input type="radio" name="Style" value="'.($i+1).'" checked="checked"/>'.$stylearr[$i];
	else
		echo '<input type="radio" name="Style" value="'.($i+1).'"/>'.$stylearr[$i];
}
?>
              </div>
              <div class="form-block">
                <label class="label" for="canteen">食堂：</label>
<?php
for($i=0; $i<=7; $i++)
{
	if($Canteen%$prime[$i]==0)
		echo '<input type="radio" name="Canteen" value="'.$prime[$i].'" checked="checked"/>'.$canteenarr[$i];
	else
		echo '<input type="radio" name="Canteen" value="'.$prime[$i].'"/>'.$canteenarr[$i];
}
?>
              </div>

              <div class="block form-btn-block form-block form-content-block">
                <span class="btn-type-b btn-fn-c">
                  <a class="form-btn" href="javascript:if(checkSubmit2())document.getElementById('contents').submit()">确认修改</a>
                </span>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="asider_n">
    <div class="box tools">
      <p>
        <form name="back" action="./Admin_log.php" method="post">
        <?php include('common_post.php');?>
        </form>
        <span class="item itoolsStyle">
          <a class="B" href="javascript:document.back.submit();">返回主面板</a>
        </span>
      </p>
    </div>
  </div>
</div>
</body>
</html>

