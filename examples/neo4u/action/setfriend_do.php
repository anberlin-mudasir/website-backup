<?php
$name="";
$pwd="";
include('../common/cookie.php');
include('../common/friend.php');
$res = setfriend($_POST['target'], $name, $pwd);
echo $res;
?>
