<?php include('common_admininfo.php'); ?>
<form method="post" name="contents" action="./Admin_update_dish_result.php">
<?php include('common_post.php'); ?>

<?php
include('mysql_db.php');


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
	
$stylearr = array("鲁菜","川菜","苏菜","粤菜","浙菜","闽菜","湘菜","徽菜","东北菜","其他");
$primenum = array(0,1,0,1,4,2,6,3,8,9,10,4,12,5,14,15,16,6,18,7,20);
$canteenarr = array("学一","学五","艺园","家园","农园","燕南","康博思","佟园");

if (!isset($_POST['Number']))
{
    echo '<input type="hidden" name="status" value="no-number"/>';
    echo '</form>';
    echo '<script>document.contents.submit()</script>';
    die('');
}
$Name_new = trim($_POST['Name']);
$Ingredients_new = trim($_POST['Ingredients']);
$Price_new = trim($_POST['Price']);
$Description_new = $_POST['Description'];
$Style_new = $_POST['Style'];
$Canteen_new = $_POST['Canteen'];
$Number_new = $_POST['Number'];
//获取本地文件
$query='select * from dishes where Number = '.$Number_new; 
$result=mysql_query($query);
$num=mysql_num_rows($result);
if($row = mysql_fetch_array($result))
	extract($row);
if($_FILES['Url_of_image']['size'] != 0)   //如果上传了文件
{
	//删除本地文件
	if($Url_of_image!="")
	{
		$filername="../../image/".$Url_of_image;
		if(file_exists($filername))
			unlink($filername);
	}

	//上传文件
	if ($_FILES["Url_of_image"]["error"] > 0)
		echo "Error: " . $_FILES["Url_of_image"]["error"] . "<br />";
	move_uploaded_file($_FILES["Url_of_image"]["tmp_name"],
      "../../image/" . $_FILES["Url_of_image"]["name"]);
	$Url_of_image_new=$_FILES["Url_of_image"]["name"];
	//echo $Url_of_image;
}
else
	$Url_of_image_new=$Url_of_image;
$Taste_new = 1;
if($_POST['allTaste'] != ""){
	$Taste_tmp = explode(" ", $_POST['allTaste']); 
	$Taste_count = count($Taste_tmp);
	for ($i = 0; $i < $Taste_count; $i++)
	{
		$Taste_new *= $Taste_tmp[$i];
	}
}

$query = 'update dishes set 
			Name = "'.$Name_new.'",
			Ingredients = "'.$Ingredients_new.'",
			Price = '.$Price_new.',
			Taste = '.$Taste_new.', 
			Style = '.$Style_new.', 
			Description = "'.$Description_new.'", 
			Canteen = '.$Canteen_new.',
			Url_of_image = "'.$Url_of_image_new.'"
		where Number = '.$Number_new; 
					
mysql_query($query,$db);
echo '<input type="hidden" name="Number" value="'.$Number.'"/>';
echo '<input type="hidden" name="status" value="succeed"/>';
echo '</form>';
echo '<script>document.contents.submit()</script>';
?>
