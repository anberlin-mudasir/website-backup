<?php
session_start();

include_once( 'include/config.php' );
include_once( 'include/saetv2.ex.class.php' );

$c = new SaeTClientV2( WB_AKEY , WB_SKEY , $_SESSION['weibo_token']['access_token'] );
$ms  = $c->home_timeline(); // done
$uid_get = $c->get_uid();
$uid = $uid_get['uid'];
$user_info = $c->show_user_by_id($uid);

?>
<html>
<head>
<title>Weibo List</title>
</head>

<body>
	<?=$user_info['screen_name']?>, Hello
	<h2 align="left">Post a new microblog</h2>
	<form action="" >
		<input type="text" name="text" style="width:300px" />
		<input type="submit" />
	</form>
<?php
if( isset($_REQUEST['text']) ) {
	$ret = $c->update( $_REQUEST['text'] );	// post new microblog
	if ( isset($ret['error_code']) && $ret['error_code'] > 0 ) {
		echo "<p>failed: {$ret['error_code']}:{$ret['error']}</p>";
	} else {
		echo "<p>succeed</p>";
	}
}
?>

<?php 
if( is_array( $ms['statuses'] ) ) {
  foreach( $ms['statuses'] as $item ) {
?>
<div style="padding:10px;margin:5px;border:1px solid #ccc">
	<?=$item['text'];?>
</div>
<?php 
  }
}
?>
<hr>
<a href="callback.php">back</a>
</body>
</html>
