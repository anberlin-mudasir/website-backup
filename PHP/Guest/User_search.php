<?xml version = "1.0" encoding = "utf-8" encoding="utf-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns = "http://www.w3.org/1999/xhtml">
<head> 
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link href="../../css/base.css" type="text/css" rel="stylesheet"/>
  <link href="../../css/login.css" type="text/css" rel="stylesheet"/>
  <link href="../../css/user.css" type="text/css" rel="stylesheet"/>
  <link href="../../css/shop-min.css" type="text/css" rel="stylesheet"/>
  <title>菜肴检索</title> 
  <script language="javascript">
  <!--    
	function checkSubmit4(){
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
      <div class="box feedBox">
        <div class="feedTip"><p>选项不必全填</p></div>
      </div>
      <h3>查找菜肴
      </h3>
    </div>
    <div class="feedList">
      <div class="section">
        <div id="cont-reg" class="block login-form">
          <div class="pop-win-inner">
            <form id="contents" method="post" action="./User_search_result.php">
              <div class="form-block">
                <label class="label" for="name">名字：</label>
                <input name="Name" id="name" class="form-default form-txt" type="text" placeholder="菜名或部分关键字" />
              </div>
              <div class="form-block">
                <label class="label" for="ingredient">原料：</label>
                <input name="Ingredients" id="ingredient" class="form-default form-txt" type="text" placeholder="如有多种请用空格分开"/>
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
                </div>
              </div>
              <div class="form-block">
                <label class="label" for="taste">菜系：</label>
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
                </select>
              </div>
              <div class="form-block">
                <label class="label" for="canteen">食堂：</label>
                <input type="radio" value="2" name="Canteen">学一
                <input type="radio" value="3" name="Canteen"/>学五
                <input type="radio" value="5" name="Canteen"/>艺园
                <input type="radio" value="7" name="Canteen"/>家园 <br/>
                <input type="radio" value="11" name="Canteen"/>农园
                <input type="radio" value="13" name="Canteen"/>燕南
                <input type="radio" value="19" name="Canteen"/>佟园 
                <input type="radio" value="17" name="Canteen"/>康博思
                <input type="hidden" name="allCanteen" value=""/>
              </div>

              <div class="block form-btn-block form-block form-content-block">
                <span class="btn-type-b btn-fn-c">
                  <a class="form-btn" href="javascript:if(checkSubmit4())document.getElementById('contents').submit()">确定</a>
                </span>
                <span class="btn-type-b btn-fn-c">
                  <a class="form-btn" href="javascript:document.getElementById('contents').reset()">重置</a>
                </span>
              </div>
            <?php include('common_post.php'); ?>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="asider_n">
    <div class="box tools">

<?php
if ($useername!='guest')
{
?>
      <p>
        <form name="alter" action="./User_change_pwd.php" method="post">
        <?php include('common_post.php');?>
        </form>
        <span class="item itoolsSet">
          <a class="B" href="javascript:document.alter.submit();">修改密码</a>
        </span>
      </p>
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
          <a class="B" href="javascript:document.back.submit()">返回</a>
        </span>
      </p>
    </div>
  </div>
</div>


</body>
</html>
