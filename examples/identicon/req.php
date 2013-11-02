<?php include('identicon.php') ?>
<?php
$identicon=new identicon;
if (isset($_POST['query'])) {
    if (isset($_POST['link'])) {
        echo $identicon->identicon_build($_POST['query'],'[alt]',false);
    } else {
        echo $identicon->identicon_build($_POST['query'],'[alt]',true);
    }
}
?>
