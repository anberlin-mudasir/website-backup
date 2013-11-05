<?php
$conn = mysql_connect("localhost", "root", "chrdwhdhxt") or die("what!");
mysql_select_db("jd_data", $conn);
mysql_query("SET NAMES 'utf8'", $conn);

$query = "select * from review limit 10";
$result = mysql_query($query) or die(mysql_error());
while ($row = mysql_fetch_row($result)) {
  print_r($row);
  echo "<br>";
}

mysql_free_result($result);
mysql_close();
?>
