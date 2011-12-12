<?php
    if (isset($_POST['useername']))
        $useername=$_POST['useername'];
    else
        $useername="guest";
    if (isset($_POST['password']))
        $password=$_POST['password'];
    else
        $password="guest";
    if ($useername != "guest")
        echo "<div style=\"text-align:right; margin-right:50px; color:#606\">你好，".$useername."!</div>";
?>
