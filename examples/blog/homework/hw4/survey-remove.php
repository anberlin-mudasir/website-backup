<?php
$del=$_POST["del"];
include('dbconn.php');
$query="delete from survey where del=".$del;
mysql_query($query) or die(mysql_error());
include('dbdisconn.php');
?>
