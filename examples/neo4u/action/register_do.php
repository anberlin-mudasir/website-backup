<?php
include('../common/user.php');
$pwd ="";
$name="";

if (isset($_POST["pwd"])) {
    $pwd=md5(trim($_POST["pwd"]));
}
if (isset($_POST["name"])) {
    $name=$_POST["name"];
}
if ($name == "") {
    die("fail");
}

if ($pwd == "") {
    $out = existuser($name);
} else {
    $out = newuser($name,$pwd);
}
$out = trim($out);
echo $out
?>
