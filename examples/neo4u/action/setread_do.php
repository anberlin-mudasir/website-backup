<?php
include('../common/cookie.php');
include('../common/msg.php');
if (isset($_POST['time'])) {
    $res = setread($_POST['name'], $_POST['time'], $name, $pwd);
} else if ($_POST['name']=="all") {
    $res = setallread($name, $pwd);
}
echo $res;
?>
