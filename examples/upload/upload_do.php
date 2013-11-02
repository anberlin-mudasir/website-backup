<form method="post" name="contents" action="./upload_result.php">
<?php
error_reporting(E_ALL & ~ E_NOTICE);

// uploaded file
/*
if ($_FILES['file']['size'] > 102400)
{
    echo "Error: file too large <br />";
    echo '<input type="hidden" name="status" value="file-large"/>';
    echo '</form>';
    echo '<script>document.contents.submit()</script>';
    die('');
}
 */
if ($_FILES["file"]["error"] > 0)
{
    echo "Error: " . $_FILES["file"]["error"] . "<br />";
    echo '<input type="hidden" name="status" value="file-error"/>';
    echo '</form>';
    echo '<script>document.contents.submit()</script>';
    die('');
}
$suffix=substr(md5(time().rand()),0,5);
$name=$_FILES['file']['name'].'.'.$suffix;
move_uploaded_file($_FILES["file"]["tmp_name"],
      "./incoming/".$name );

echo '<input type="hidden" name="status" value="succeed"/>';
echo '</form>';
echo '<script>document.contents.submit()</script>';
?>
