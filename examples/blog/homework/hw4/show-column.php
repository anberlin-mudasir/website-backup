<?php
mysql_connect("localhost","usr_2011_44","internetics") or die("Could not connect database");
mysql_select_db("db_2011_44") or die("Could not select database");

/*
$query="desc survey";       // Intuitive way to get labels
$result=mysql_query($query) or die(mysql_error());

while($row=mysql_fetch_array($result))
{
   echo $row[0]."<br/>";
}
*/

$query="select * from survey";
$result=mysql_query($query) or die(mysql_error());
$num_fields = mysql_num_fields($result);
$row=mysql_fetch_array($result);
$keys=array_keys($row);     // A little tricky, but more convenient
for ($i=0; $i<$num_fields; $i++)
    echo $keys[2*$i+1]." <br/>";

mysql_free_result($result);
mysql_close();
?>
