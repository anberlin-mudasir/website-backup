<?php
session_start();

include_once( 'include/config.php' );
include_once( 'include/saetv2.ex.class.php' );

$o = new SaeTOAuthV2( WB_AKEY , WB_SKEY );

if (isset($_SESSION['weibo_token'])) {
  $token = $_SESSION['weibo_token'];
}
if (isset($_REQUEST['code'])) {
	$keys = array();
	$keys['code'] = $_REQUEST['code'];
	$keys['redirect_uri'] = WB_CALLBACK_URL;
	try {
		$token = $o->getAccessToken( 'code', $keys ) ;
	} catch (OAuthException $e) {
	}
}

if ($token) {
	$_SESSION['weibo_token'] = $token;
	setcookie( 'weibojs_'.$o->client_id, http_build_query($token) );
?>
callback page from login, <br/>
<a href="userinfo.php">here</a> is your user info, <br/>
<a href="weibolist.php">here</a> is a weibo list for you<br/>
<?php
} else {
?>
authorization failed...
<?php
}
?>
<hr>
<a href="../">back</a>
