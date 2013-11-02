<?php
//查看cookie信息
echo "cookie:<br>";
foreach ($_COOKIE as $k => $v) {
    echo "[".$k."=>".$v."]<br>";
}
?>
