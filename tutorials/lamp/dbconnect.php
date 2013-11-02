<!--this file includes some base connect operation for mysql-->
<?php
mysql_connect("localhost","root","chdyl,") or die("Could not connect to database");
mysql_select_db("cet6") or die("Could not select database");
?>
