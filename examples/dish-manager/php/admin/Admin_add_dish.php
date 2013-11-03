<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns = "http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>添加菜肴</title>
  <link href="../../css/base.css" type="text/css" rel="stylesheet"/>
  <link href="../../css/login.css" type="text/css" rel="stylesheet"/>
  <link href="../../css/user.css" type="text/css" rel="stylesheet"/>
  <link href="../../css/shop-min.css" type="text/css" rel="stylesheet"/>
  <script type="text/javascript">
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
</head> 
<body>
<?php include('common_admininfo.php'); ?>
<?php
    error_reporting(E_ALL & ~ E_NOTICE);
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


<div class="main_w">
  <br />
  <div class="content_n">
    <div class="memberBox">
      <h3>添加菜肴
      </h3>
    </div>
    <div class="feedList">
      <div class="section">
        <div id="cont-reg" class="block login-form">
          <div class="pop-win-inner">
            <form id="contents" enctype="multipart/form-data" method="post" action="Admin_add_dish_do.php">
              <?php include('common_post.php');?>
              <div class="form-block">
                <label class="label" for="name">名字：</label>
                <input name="Name" id="name" class="form-default" type="text" placeholder="菜名" />

              </div>
              <div class="form-block">
                <label class="label" for="ingredient">原料：</label>
                <input name="Ingredients" id="ingredient" class="form-default" type="text" placeholder="如有多种请用空格分开"/>
              </div>
              <div class="form-block">
                <label class="label" for="price">价格：</label>
                <input name="Price" id="price" class="form-default" type="text" placeholder="每两价格"/>
              </div>
              <div class="form-block">
                <label class="label" for="picture">图片：</label>
                <input name="Url_of_image" id="picture" class="form-default" type="file"/>
              </div>

              <div class="form-block">
                <label class="label" for="description">描述：</label>
                <textarea rows="4" name="Description" id="description" class="form-default"></textarea>
              </div>
              <div class="form-block">
                <label class="label" for="taste">口味：</label>
                <div>
                  <input type="checkbox" value="2" name="Taste"/>酸
                  <input type="checkbox" value="3" name="Taste"/>甜
                  <input type="checkbox" value="5" name="Taste"/>苦
                  <input type="checkbox" value="7" name="Taste"/>辣 <br/>
                  <input type="checkbox" value="11" name="Taste"/>咸
                  <input type="checkbox" value="13" name="Taste"/>淡
                  <input type="checkbox" value="17" name="Taste"/>麻 
                  <input type="checkbox" value="19" name="Taste"/>鲜
                  <input type="hidden" value="" name="allTaste">
                  <input type="hidden" value="" name="allTasteInC">
                </div>
              </div>
              <div class="form-block">
                <label class="label" for="style">菜系：</label>
                <select id="style" name="Style">
	              <option value="1">鲁菜</option>
                  <option value="2">川菜</option>
                  <option value="3">苏菜</option>
                  <option value="4">粤菜</option>
                  <option value="5">浙菜</option>
                  <option value="6">闽菜</option>
                  <option value="7">湘菜</option>
                  <option value="8">徽菜</option>
                  <option value="9">东北菜</option>
                  <option value="10">其他</option>
                </select>
              </div>
              <div class="form-block">
                <label class="label" for="canteen">食堂：</label>
                <input type="radio" checked="checked" value="2" name="Canteen">学一
                <input type="radio" value="3" name="Canteen"/>学五
                <input type="radio" value="5" name="Canteen"/>艺园
                <input type="radio" value="7" name="Canteen"/>家园 <br/>
                <input type="radio" value="11" name="Canteen"/>农园
                <input type="radio" value="13" name="Canteen"/>燕南
                <input type="radio" value="19" name="Canteen"/>佟园 
                <input type="radio" value="17" name="Canteen"/>康博思
              </div>

              <div class="block form-btn-block form-block form-content-block">
                <span class="btn-type-b btn-fn-c">
                  <a class="form-btn" href="javascript:if(checkSubmit2())document.getElementById('contents').submit()">添加菜肴</a>
                </span>
                <span class="btn-type-b btn-fn-c">
                  <a class="form-btn" href="javascript:document.getElementById('contents').reset()">重置</a>
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
