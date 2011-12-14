<?php include('common_admininfo.php'); ?>
<form method="post" name="contents" action="./Admin_del_dish_result.php">
<?php include('common_post.php'); ?>

<?php
$db = mysql_connect("","se","se");
mysql_select_db('meal',$db);

$query='select * from admin where name="'.$useername.'" and pass="'.$password.'"';
$query=stripslashes($query);
$result=mysql_query($query);
$num=mysql_num_rows($result);
if($num==0)
{
    echo '<input type="hidden" name="status" value="pass-error"/>';
    echo '</form>';
    echo '<script>document.contents.submit()</script>';
    die('');
}

$canteen_count = count($_POST['deleteNumber']);
$canteen_tmp=$_POST['deleteNumber'];

for ($i = 0; $i < $canteen_count; $i++)
{
	$query = 'select * from dishes where Number = '.$canteen_tmp[$i];
	$result = mysql_query($query,$db);
	if($row = mysql_fetch_array($result)){
		extract($row);
		if(NULL != $Opinion_table_name)
		{
			$query = 'drop table '.$Opinion_table_name;
			$result = mysql_query($query,$db);
		}
	}
	//删除图片
	if($Url_of_image!="")
	{
		$filername="../../image/".$Url_of_image;
		if(file_exists($filername))
			unlink($filername);
	}
    $query = 'delete from dishes where Number = '.$canteen_tmp[$i];
	mysql_query($query,$db);
}

echo '<input type="hidden" name="status" value="succeed"/>';
echo '</form>';
echo '<script>document.contents.submit()</script>';
?>
