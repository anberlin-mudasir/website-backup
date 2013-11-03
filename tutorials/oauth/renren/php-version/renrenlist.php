<?php
session_start();

include_once('include/config.php');
include_once('include/RennClient.php');

$renn_client = new RennClient(APP_KEY, APP_SECRET);
$renn_client->setDebug(DEBUG_MODE);
$renn_client->authWithStoredToken();
$user_service = $renn_client->getUserService();
// get current login user 
$user = $user_service->getUserLogin();
$uid = $user['id'];
$status_service = $renn_client->getStatusService();
$status_num = 10;
$status_page = 1;
$status_list = $status_service->listStatus($uid, $status_num, $status_page);

?>
<html>
<head>
<title>renren demo</title>
</head>
<body>
  <h2 align="left"> Post a new renren status</h2>
  <form action="">
    <input type="text" name="text" style="width:240px"/>
    <input type="submit"/>
  </form>
<?php
if (isset($_REQUEST['text'])) {
  try {
    $ret = $status_service->putStatus($_REQUEST['text']);  // post new status
    echo "new post:";
    print_r($ret);
    echo "<br>";
  } catch (ServerException $e) {
    echo "fail to post!";
  }
}
?>

<?php
if (is_array($status_list)) {
  foreach ($status_list as $status) {
?>
<div style="padding:10px;margin:5px;border:1px solid #ccc">
<?php
    print_r($status);
?>
</div>
<?php
  }
}
?>
<hr>
<a href="callback.php">back</a>
</body>
</html>
