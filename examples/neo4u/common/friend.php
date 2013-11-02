<?php
include('socket.php');

function fetch_friendnum($target, $name, $pwd) {
    return tcprequest(array("getfriendnum",$target,$name,$pwd));
}
function fetch_friends($target, $name, $pwd) {
    return tcprequest(array("getfriends",$target,$name,$pwd));
}
function fetch_reversefriendnum($target, $name, $pwd) {
    return tcprequest(array("getreversefriendnum",$target,$name,$pwd));
}
function fetch_reversefriends($target, $name, $pwd) {
    return tcprequest(array("getreversefriends",$target,$name,$pwd));
}
function fetch_recommendfriends($name, $pwd) {
    return tcprequest(array("recommendfriends",$name,$pwd));
}
function setfriend($target, $name, $pwd) {
    return tcprequest(array("setfriend",$target,$name,$pwd));
}
function delfriend($target, $name, $pwd) {
    return tcprequest(array("delfriend",$target,$name,$pwd));
}
function search($target, $name, $pwd) {
    return tcprequest(array("search",$target,$name,$pwd));
}
function isfriend($target, $name, $pwd) {
    return tcprequest(array("isfriend",$target,$name,$pwd));
}
?>
