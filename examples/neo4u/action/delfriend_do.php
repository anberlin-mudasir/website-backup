<?php
include('../common/cookie.php');
include('../common/friend.php');
$res = delfriend($_POST['target'], $name, $pwd);
echo $res;
?>
