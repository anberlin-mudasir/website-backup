<?php
session_start ();

include_once ('include/config.php');
include_once ('include/RennClient.php');

$rennClient = new RennClient ( APP_KEY, APP_SECRET );
$rennClient->setDebug ( DEBUG_MODE );

if (isset($_SESSION['renren_token'])) {
  $token = $_SESSION['renren_token'];
}

if (isset ( $_REQUEST ['code'] )) {
  $keys = array ();
  $keys['code'] = $_REQUEST['code'];
  $keys['redirect_uri'] = CALLBACK_URL;
  try {
    $token = $rennClient->getTokenFromTokenEndpoint ('code', $keys);
  } catch (RennException $e) {
    //var_dump ( $e );
  }
}

if ($token) {
  $_SESSION['renren_token'] = $token;
?>
<p>authorization succeed</p>

<p>Click <a href="userinfo.php">here</a> to see user information.</p>
<p>Click <a href="renrenlist.php">here</a> to see your posts.</p>

<br />
<?php
} else {
?>
<p>authorization failed</p>
<?php
}
?>
