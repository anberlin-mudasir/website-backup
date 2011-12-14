<?php include('common_admininfo.php'); ?>
<form method="post" name="contents" action="./Admin_add_dish_result.php">
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

$Name = trim($_POST['Name']);
$Ingredients = trim($_POST['Ingredients']);
$Price = trim($_POST['Price']);
$Description = $_POST['Description'];
$Style = $_POST['Style'];
$Canteen = $_POST['Canteen'];

// uploaded file
if ($_FILES["Url_of_image"]["error"] > 0)
{
    echo "Error: " . $_FILES["Url_of_image"]["error"] . "<br />";
    echo '<input type="hidden" name="status" value="file-error"/>';
    echo '</form>';
    echo '<script>document.contents.submit()</script>';
    die('');
}
move_uploaded_file($_FILES["Url_of_image"]["tmp_name"],
      "../../image/" . $_FILES["Url_of_image"]["name"]);
$Url_of_image=$_FILES["Url_of_image"]["name"];

$Taste = 1;
if($_POST['allTaste'] != ""){
	$Taste_tmp = explode(" ", $_POST['allTaste']); 
	$Taste_count = count($Taste_tmp);
	for ($i = 0; $i < $Taste_count; $i++)
		$Taste *= $Taste_tmp[$i];
}
$query = "insert into dishes (Name,Ingredients,Price,Url_of_image,Description,
			Taste,Style,Canteen,Guest_count,Grade) values	
	     ('$Name','$Ingredients','$Price','$Url_of_image','$Description',
			'$Taste','$Style','$Canteen',0,0)";
			
mysql_query($query,$db);

echo '<input type="hidden" name="status" value="succeed"/>';
echo '</form>';
echo '<script>document.contents.submit()</script>';
?>
