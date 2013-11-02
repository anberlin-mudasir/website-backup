<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
<title>Hw3</title>
<!--external style -->
<link href="css/style.css" type="text/css" rel="stylesheet"/>
<!--internal style -->
<style type="text/css">
div.side
{
top:97px;
width:210px;
margin:0px 3px 0px 5px;
position:fixed;
padding: 5px 5px 5px 5px;
}
</style>
<script type="text/javascript">
function toggle() {
    if (document.getElementById("result").style.display=="none")
        document.getElementById("result").style.display="block";
    else
        document.getElementById("result").style.display="none";
}
function append() {
    var name;
    var age;
    var gender;
    var mail;
    if (document.survey.gender[0].checked==true)
        gender="male";
    else
        gender="female";
    name=document.survey.name.value;
    age=document.survey.age.value;
    mail=document.survey.mail.value;
    if (!name || !mail)
    {
        alert("Well...you fogot some infomation?");
        return;
    }
    if (!age || isNaN(age) || age < 0 || age > 120)
    {
        alert("oh, I assume age to be 0~120..");
        return;
    }
    var req="name="+name+"&age="+age+"&mail="+mail+"&gender="+gender;
    var content=[name,age,gender,mail];
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            var id=xmlhttp.responseText;
            var new_row="<tr id=\"row_"+id+"\"><td>";
            new_row+=content.join("</td><td>");
            new_row+="</td>";
            new_row+="<td><input type=\"button\" class=\"x\" onclick=\"remove("+id+")\"/></td>";
            new_row+="</tr>";
            document.getElementById("tbody").innerHTML+=new_row;
            if (document.getElementById("result").style.display=="none")
                document.getElementById("result").style.display="block";
        }
    }
    xmlhttp.open("POST","survey-append.php",true);
    xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xmlhttp.send(req);
}
function remove(id)
{
    var rid="row_"+id;
    var req="del="+id;
    document.getElementById(rid).style.display="none";
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        //if (xmlhttp.readyState==4 && xmlhttp.status==200)
        //{
         //   alert(xmlhttp.responseText);
        //}
    }
    xmlhttp.open("POST","survey-remove.php",true);
    xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xmlhttp.send(req);
}
</script>
</head>

<body>
<div class="container">
<div class="header"><h1>Simple Survey -- AJAX version</h1></div>
<div class="wrap">
<div class="content"> 
    <h2>Welcome to our survey!</h2>
    <p>We'll appreciate it if you give a hand!<br/>
    The data will update dynamically in the result list.</p>
    <form class="boxwrap" name="survey" method="post" action="javascript:append()">
    <h4>Your name?</h4>
    <input type="text" value="" name="name"/>
    <h4>Your age?</h4>
    <input type="text" value="" name="age"/>
    <h4>Your gender?</h4>
    <input type="radio" value="male" name="gender" checked/> Male
    <input type="radio" value="female" name="gender"/> Female
    <h4>Your E-mail?</h4>
    <input type="text" value="" name="mail"/>
    <br/>
    <br/>
    <input type="submit" value="Submit Order!"/>
    <input type="reset" value="Clear the form?"/>
    <br/> <br/>
    </form>
    <br/>
    <a class="box" href="#result" onclick="toggle()">Click here if you want to toggle the result show</a>
    <br/>
    <div id="result" class="boxwrap" style="display:none">
    <table border="1" style="margin:auto;text-align:center">
    <caption>
    <h3>Current result:</h3>
    </caption>
    <tbody id="tbody">
<?php
include('survey-show.php');
?>
    </tbody>
    </table>
    </div>
</div>
 <!--inline style-->
<div class="side" style="left:4px;float:left">
An AJAX version of survey is available!
</div>
<div class="side" style="right:4px;float:right">
Well, I feel quite sorry that php webpages cannot be checked by W3C validation.
</div>
</div>
<div class="footer">
<p>powered by Billy</p>
</div>
</div>
</body>
</html>
