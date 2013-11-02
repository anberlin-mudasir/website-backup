<?php
session_start();

include_once( 'include/config.php' );
include_once( 'include/saetv2.ex.class.php' );

$o = new SaeTOAuthV2( WB_AKEY , WB_SKEY );
$code_url = $o->getAuthorizeURL( WB_CALLBACK_URL, 'code', NULL, 'default' );

?>
<html>
<head>
<title>Weibo Demo</title>
</head>

<body>
    Login page
    <p><a href="<?=$code_url?>">login</a></p>
    <hr>
    <p><a href="../">back</a></p>
</body>
</html>
