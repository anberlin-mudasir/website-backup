<?php
session_start ();

include_once ('include/config.php');
include_once ('include/RennClient.php');

$rennClient = new RennClient ( APP_KEY, APP_SECRET );
$rennClient->setDebug ( DEBUG_MODE );

$state = uniqid ( 'renren_', true );

$code_url = $rennClient->getAuthorizeURL ( CALLBACK_URL, 'code', $state );
?>

<html>
<head>
<title>Renren demo</title>
</head>

<body>
  <p>Login page:</p>
  <p>
    <a href="<?=$code_url?>">login</a>
  </p>
  <hr>
  <a href="/">Back</a>
</body>
</html>
