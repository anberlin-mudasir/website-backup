<?xml version = "1.0" encoding = "utf-8" encoding="utf-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns = "http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>用户注册</title>
<style>
body {
    background-image:url(../../image/Admin_log_p_back.jpg);
	font-size:24px;
}
h2 {
	text-align:center;
}
a.box:link,a.box:visited
{
    display:block;
    font-weight:bold;
    color:#FFFFFF;
    background-color:#000080;
    width:100px;
    text-align:center;
    padding:4px;
    text-decoration:none;
    font-size:0.8em;
    margin:auto;
}
a.box:hover,a.box:active
{
    background-color:#333399;
}
</style>
<script type="text/javascript">
function append() {
    var name;
    var pass;
    var pass2;
    name=document.reg.name.value;
    pass=document.reg.password.value;
    pass2=document.reg.renewpassword.value;
    if (pass!=pass2)
        alert("密码错误，请重新输入");
    else
    {
        var req="name="+name+"&pass="+pass;
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
                    alert('注册成功!请用新用户名登录');
                    window.location='../../index.html';
                }
                else
                {
                    alert('用户名已存在'); 
                }
            }
        }
        xmlhttp.open("POST","User_append.php",true);
        xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xmlhttp.send(req);
    }
}
</script>
</head>
<body>
<div> <h2>北京大学餐饮信息查询系统</h2></div>
<div style="margin:auto; width:25%">
<form id="reg" name="reg" method="post">
    <table border="0"><tbody>
    <tr>
        <td>用户名: </td>
        <td><input type="text" name="name" /></td>
    </tr>
    <tr>
        <td>密码: </td>
        <td><input type="password" name="password" /></td>
    </tr>
    <tr>
        <td>重复密码: </td>
        <td><input type="password" name="renewpassword" /></td>
    </tr>
    </table>
</form>
<a class="box" href="#reg" onclick="javascript:append()">确认</a>
</div>
</body>
</html>















