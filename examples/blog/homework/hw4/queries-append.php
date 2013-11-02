<?php
$name=$_POST["name"];
$gender=$_POST["gender"];
$mail=$_POST["mail"];
$age=$_POST["age"];
$party=$_POST["party"];
include('dbconn.php');

$query="select * from party where Party_Num=$party";
$result=mysql_query($query) or die(mysql_error());
$num_lines = mysql_num_rows($result);
if ($num_lines==0)
    die("You tried to attend an invalid Party...");

$query="insert into guest values(0,\"".$name."\",".$age.",\"".$gender."\",\"".$mail."\")";
mysql_query($query) or die(mysql_error());
$query="select MAX(Guest_ID) from guest";
$result=mysql_query($query) or die(mysql_error());
$row=mysql_fetch_array($result);
$id=$row[0];

$query="insert into `guest-party` values($id,$party)";
mysql_query($query) or die(mysql_error());

echo $id;   // send back current id;
mysql_free_result($result);
include('dbdisconn.php');
?>
