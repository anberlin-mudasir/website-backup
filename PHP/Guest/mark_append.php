<?php
$name=$_POST['name'];
$num=$_POST['number'];
mysql_connect("localhost","se","se") or die("Could not connect to database");
mysql_select_db("meal") or die("Could not select database");

$query='insert into mark values("'.$name.'","'.$num.'")';
$query=stripslashes($query);
mysql_query($query);
echo "succeed";
?>
