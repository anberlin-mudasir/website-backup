<?php
echo "POST:<br>";
foreach ($_POST as $k => $v) {
    echo "[".$k."=>".$v."]<br>";
}
echo "GET:<br>";
foreach ($_GET as $k => $v) {
    echo "[".$k."=>".$v."]<br>";
}
?>
