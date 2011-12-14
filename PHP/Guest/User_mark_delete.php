<?php
$db = mysql_connect("","se","se");
mysql_select_db('meal',$db);

$useername=$_POST['name'];
$canteen_count = count($_POST['deleteNumber']);
$canteen_tmp=$_POST['deleteNumber'];

for ($i = 0; $i < $canteen_count; $i++)
{
    $query = 'delete from mark where Number = '.$canteen_tmp[$i].' and User="'.$useername.'"';
	mysql_query($query,$db);
}

echo 'succeed';
?>
