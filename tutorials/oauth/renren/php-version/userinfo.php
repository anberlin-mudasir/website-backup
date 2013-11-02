<?php
session_start ();

include_once ('include/config.php');
include_once ('include/RennClient.php');

$renn_client = new RennClient ( APP_KEY, APP_SECRET );
$renn_client->setDebug ( DEBUG_MODE );
$renn_client->authWithStoredToken ();
$user_service = $renn_client->getUserService ();
// get current login user 
$user = $user_service->getUserLogin ();
$uid = $user['id'];
$user_login = $user_service->getUserLogin ();
$user_profile = $user_service->getUser($uid);

$dump = array(
  'user_login' => $user_login,
  'user_profile' => $user_profile,
);

?>
<html>
<head>
<title>renren demo</title>
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
<a href="index.php">back</a>
</body>
</html>
