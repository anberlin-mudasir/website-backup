<?php
include('../common/cookie.php');
if ($name=="" || $pwd=="") {
    $res="none";
    header("Location: login.html"); 
}
include('../common/user.php');
$res = verify($name,$pwd);
$res = trim($res);
echo $res;
?>
