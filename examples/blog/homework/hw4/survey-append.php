<?php
$name=$_POST["name"];
$gender=$_POST["gender"];
$mail=$_POST["mail"];
$age=$_POST["age"];
include('dbconn.php');
$query="insert into survey values(\"".$name."\",".$age.",\"".$gender."\",\"".$mail."\",0)";
mysql_query($query) or die(mysql_error());
$query="select MAX(del) from survey";
$result=mysql_query($query) or die(mysql_error());
$row=mysql_fetch_array($result);
echo $row[0];   // send back current id;
include('dbdisconn.php');
?>
