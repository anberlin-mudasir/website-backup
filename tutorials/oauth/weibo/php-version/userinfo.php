<?php
session_start();

include_once( 'include/config.php' );
include_once( 'include/saetv2.ex.class.php' );


$c = new SaeTClientV2( WB_AKEY , WB_SKEY , $_SESSION['weibo_token']['access_token'] );
$uid_get = $c->get_uid();
$uid = $uid_get['uid'];
$user_info = $c->show_user_by_id($uid);
$user_profile = $c->account_profile_basic();
$user_email = $c->account_profile_email();
$user_edu = $c->account_education();

$dump = array(
  'user_info' => $user_info,
  'user_profile' => $user_profile,
  'user_email' => $user_email,
  'user_edu' => $user_edu,
);


?>
<html>
<head>
<title>User Info</title>
</head>

<body>

<?php
foreach ($dump as $key => $value) {
  echo "<h3>$key:</h3>";
  foreach ($value as $k => $v) {
    echo "$k=";
    print_r($v);
    echo "<br>";
  }
  echo "<br>";
}
?>
<hr>
<a href="callback.php">back</a>
</body>
</html>
