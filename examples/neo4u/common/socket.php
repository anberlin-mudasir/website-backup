<?php
function tcprequest($req) {
    $service_port = 10000;
    $address = 'localhost';

    if (($socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) === false) {
        return false;   
    }
    if (($result = socket_connect($socket, $address, $service_port)) === false) {
        return false;
    }

    $in = join("\n",$req);
    $out = '';

    socket_write($socket, $in, strlen($in));
    socket_shutdown($socket, 1);
        
    $out = socket_read($socket, 204800);
    socket_close($socket);
    return $out;
}
?>
