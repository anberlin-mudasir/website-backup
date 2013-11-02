<?php
include('../common/cookie.php');
include('../common/msg.php');
$res = postmsg($_POST['str'], $name, $pwd);
echo $res;
?>
