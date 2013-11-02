<?php
header ( 'Content-Type: text/html; charset=UTF-8' );

define ( 'DEBUG_MODE', false );

if (! function_exists ( 'curl_init' )) {
	echo 'your server does not support curl in PHP';
	exit ();
}

define ( "APP_KEY", 'e53d57a5a76b43588d3f2a0577222270' );
define ( "APP_SECRET", '394c90d3d35349408d9893eea2228dd1' );
define ( "CALLBACK_URL", "http://www.lichen.pw/~billybob/renren/php-version/callback.php" );

if (DEBUG_MODE) {
	error_reporting ( E_ALL );
	ini_set ( 'display_errors', true );
}
