<?php
include('socket.php');

function existuser($name) {
    return tcprequest(array("existuser",$name));
}
function newuser($name, $pwd) {
    return tcprequest(array("newuser",$name,$pwd));
}
function verify($name, $pwd) {
    return tcprequest(array("judge",$name,$pwd));
}
?>
