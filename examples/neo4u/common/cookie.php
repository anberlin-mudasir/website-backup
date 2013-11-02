<?php
$pwd="";
$name="";
if (isset($_POST["name"]) and isset($_POST["pwd"])) {
    $name=$_POST["name"];
    $pwd=md5(trim($_POST["pwd"]));
    if (isset($_POST["remember"])) {
        $expire=60*60*24*7;
    } else {
        $expire=60*5;
    }
    setcookie("name-121212", $name,time()+$expire); // one week to expire
    setcookie("pwd-121212", $pwd,time()+$expire); // one week to expire
} else if (isset($_COOKIE["name-121212"]) and isset($_COOKIE["pwd-121212"])) {
    $name=$_COOKIE["name-121212"];
    $pwd=$_COOKIE["pwd-121212"];
    setcookie("name-121212", $name,time()+60*5); // invalid after 5 minites
    setcookie("pwd-121212", $pwd,time()+60*5);
}
?>
