<?php
$name=$_POST["name"];
$mail=$_POST["mail"];
$party=$_POST["party"];
include('dbconn.php');

$query="select a.Guest_ID from guest a,`guest-party` b where Guest_Name=\"$name\" and E_mail=\"$mail\" and a.Guest_ID=b.Guest_ID and b.Party_Num=$party";
$result=mysql_query($query) or die(mysql_error());

while($row=mysql_fetch_array($result))
{
    $ids[]=$row[0];
}

for ($i=0; $i<sizeof($ids); $i++)
{
    $query="delete from `guest-party` where Guest_ID=".$ids[$i]." and Party_Num=$party";
    mysql_query($query) or die(mysql_error());
}

// delete those non-party guests
$query="select * from  guest where Guest_ID not in (select a.Guest_ID Guest_ID from `guest-party` a left join guest b on a.Guest_ID=b.Guest_ID)";
$result=mysql_query($query) or die(mysql_error());
while($row=mysql_fetch_array($result))
{
    $ids[]=$row[0];
} // send back hit ids;

if (sizeof($ids)!=0)
    echo join("\n",$ids);

for ($i=0; $i<sizeof($ids); $i++)
{
    $query="delete from guest where Guest_ID=".$ids[$i];
    mysql_query($query) or die(mysql_error());
}
mysql_free_result($result);
include('dbdisconn.php');
?>
