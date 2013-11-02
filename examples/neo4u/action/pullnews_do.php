<?php
include('../common/cookie.php');
include('../common/msg.php');
include('../common/identicon.php');
$identicon=new identicon;
if (isset($_POST['offset']) && isset($_POST['ddl'])) {
    $res = pullnews($_POST['ddl'],$name, $pwd);
    $html="";
    $content=array();
    $cnt=0;
    foreach(preg_split("/((\r?\n)|(\r\n?))/", $res) as $line){
        $content[$cnt] = $line;
        $cnt++;
    }
    echo $content[0]."\n";
    for ($i=1; $i+2<$cnt; $i+=3) {
        $tname=trim($content[$i]);
        $tcontent=trim($content[$i+1]);
        $ttime=trim($content[$i+2]);
        if (mb_strlen($tcontent,'utf-8')>30)
            $ttitle=mb_substr($tcontent,0,30,'utf-8')."...";
        else
            $ttitle=$tcontent;
        $timg=$identicon->identicon_build($tname,'[alt]',false);
        $k=$i+$_POST['offset']-1;
?>
            <div style="display:none" class="accordion-group in new">
            <a onclick="javascript:setread(<?php echo $k ?>)" href="#" class="fade close" data-dismiss="alert">&times;</a>
              <div class="accordion-heading">
                <span class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse<?php echo $k ?>">
                <a data-original-title="<img src='<?php echo $timg; ?>'/>  <a href=''><?php echo $tname ?></a>" href="./othr.php?name=<?php echo $tname ?>" class="popover-test" data-content="">
                <img class="msg" src="<?php echo $timg; ?>"></a>:

                <a><?php echo $ttitle; ?></a>
                </span>
              </div>
              <div id="collapse<?php echo $k ?>" class="accordion-body collapse">
                <div class="accordion-inner">
                <p><a href="./othr.php?name=<?php echo $tname ?>" id="name<?php echo $k ?>"><?php echo $tname ?></a>说:</p>
                <blockquote><p class="quote"><?php echo $tcontent ?></p></blockquote>
                <p><small id="time<?php echo $k ?>"><?php echo $ttime ?></small></p>
                </div>
              </div>
            </div>
<?php
    }
} else {
    $res = "fail";
}
?>
