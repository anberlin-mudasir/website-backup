<?php
$name=$_POST['name'];
$pass=$_POST['pass'];
include('mysql_db.php');

$query='select * from user where name="'.$name.'"';
$query=stripslashes($query);
$result=mysql_query($query);
$num=mysql_num_rows($result);
if ($num!=0)
{
    die('dup');
}
$query='insert into user values("'.$name.'","'.$pass.'")';
$query=stripslashes($query);
mysql_query($query);
echo "succeed";
?>
