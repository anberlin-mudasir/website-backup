<?php
$name=$_POST['name'];
$num=$_POST['number'];
include('mysql_db.php');


$query='insert into mark values("'.$name.'","'.$num.'")';
$query=stripslashes($query);
mysql_query($query);
echo "succeed";
?>
