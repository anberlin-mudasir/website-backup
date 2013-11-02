<?php
// 从post读取hello域信息，放在_COOKIE['hello']中的变量只有20秒的寿命 
echo "post:";
foreach ($_POST as $k => $v) {
    echo "[".$k."=>".$v."]<br>";
}
echo "<br>";
echo "cookie:";
foreach ($_COOKIE as $k => $v) {
    echo "[".$k."=>".$v."]<br>";
}
echo "<br>";
if (isset($_POST['hello'])) {
    setcookie("hello", $_POST['hello'],time()+20);//60*60*24*7);
}
?>
