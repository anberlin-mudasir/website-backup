<?php
include('socket.php');

function fetch_msg($target, $name, $pwd) {
    return tcprequest(array("getmsg",$target,$name,$pwd));
}
function fetch_news($name, $pwd) {
    return tcprequest(array("getnews",$name,$pwd));
}
function setread($target_name, $target_time, $name, $pwd) {
    return tcprequest(array("setread",$target_name,$target_time,$name,$pwd));
}
function setallread($name, $pwd) {
    return tcprequest(array("setallread",$name,$pwd));
}
function postmsg($str, $name, $pwd) {
    return tcprequest(array("postmsg",$str,$name,$pwd));
}
function pullnews($ddl, $name, $pwd) {
    return tcprequest(array("pullnews",$ddl,$name,$pwd));
}
?>
