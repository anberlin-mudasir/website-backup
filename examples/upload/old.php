<?php
session_start();
$redirect = "old.php";
$numfiles=3;


if(isset($_GET['progress_key'])) {
  $status = apc_fetch('upload_'.$_GET['progress_key']);
  echo json_encode($status);
  exit;
}

if($_SERVER['REQUEST_METHOD']=='POST') {
    $status = apc_fetch('upload_'.$_POST['APC_UPLOAD_PROGRESS']);

    //if($_POST['name']) {
        $i=0;
        foreach ($_FILES['file']['type'] as $key => $value) {
            $i+=1;
            $uploaddir = "./incoming/";
            $filename = $_FILES['file']['name'][$key];
            $uploadfile = $uploaddir . $filename;
            move_uploaded_file($_FILES['file']['tmp_name'][$key], $uploadfile);
            $file = $filename;
        }
        //set a session for confirmation message
        if($i>0)
            $_SESSION['success'] = 1;
    //}
    $status['done'] = 1;
    echo json_encode($status);
    exit;
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns = "http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>文件上传</title>
  <script type="text/javascript" src="yui/yahoo.js"></script>
  <script type="text/javascript" src="yui/event.js"></script>
  <script type="text/javascript" src="yui/dom.js"></script>
  <script type="text/javascript" src="yui/animation.js"></script>
  <script type="text/javascript" src="yui/dragdrop.js"></script>
  <script type="text/javascript" src="yui/connection.js"></script>
  <script type="text/javascript" src="yui/container.js"></script>
  <link rel="stylesheet" type="text/css" href="yui/container.css" />
  <link href="css/base.css" type="text/css" rel="stylesheet"/>
  <link href="css/login.css" type="text/css" rel="stylesheet"/>
  <link href="css/user.css" type="text/css" rel="stylesheet"/>
  <link href="css/shop-min.css" type="text/css" rel="stylesheet"/>
<script type="text/javascript">
var fN = function callBack(o) {
  var resp = eval('(' + o.responseText + ')');
  var rate = parseInt(resp['rate']/1024);
  if(resp['cancel_upload']) {
    txt=""; 
  } else {
    txt="";
  }
<!--  txt += "<br>Upload rate was "+rate+" kbps.";-->
  document.getElementById('pbar').style.width = '100%';
  document.getElementById('ppct').innerHTML = "100%";
  document.getElementById('ptxt').innerHTML = txt;
  setTimeout("progress_win.hide(); window.location.reload()",5000);
  window.location = "<?php echo $redirect; ?>"
}
var callback = { upload:fN }

var fP = function callBack(o) {
  var resp = eval('(' + o.responseText + ')');
  if(!resp['done']) { 
    if(resp['total']) {
      var pct = parseInt(100*(resp['current']/resp['total']));
      document.getElementById('pbar').style.width = ''+pct+'%';
      document.getElementById('ppct').innerHTML = " "+pct+"%";
<!--      document.getElementById('ptxt').innerHTML = resp['current']+" of "+resp['total']+" bytes";-->
    }
    setTimeout("update_progress()",500);
  } else if(resp['cancel_upload']) {
    txt=" "; 
    document.getElementById('ptxt').innerHTML = txt;
    setTimeout("progress_win.hide(); window.location.reload();",500000);
   // window.location = "<?php echo $redirect; ?>"
  }
}
var progress_callback = { success:fP }

function update_progress() {
  progress_key = document.getElementById('progress_key').value;
  YAHOO.util.Connect.asyncRequest('GET','old.php?progress_key='+progress_key, progress_callback);
}

var progress_win;

function postForm(target,formName) {
  YAHOO.util.Connect.setForm(formName,true);
  YAHOO.util.Connect.asyncRequest('POST',target,callback);
/* Is there some event that triggers on an aborted file upload? */
/*   YAHOO.util.Event.addListener(window, "abort", function () { alert('abort') } ); */

  progress_win = new YAHOO.widget.Panel("progress_win", { width:"420px", fixedcenter:true, underlay:"shadow", close:false, draggable:false, modal:true, effect:{effect:YAHOO.widget.ContainerEffect.FADE, duration:0.3} } );
  progress_win.setHeader("Uploading file...");
  progress_win.setBody('<div style="height: 1em; width: 400px; border:1px solid #000;"> <div id="pbar" style="background: #99e; height: 98%; width:0%; float:none;">&nbsp;</div> <div id="ppct" style="height: 90%; margin: 1 0 0 185;">0%</div></div><div id="ptxt" style="height:10px; margin: 3 0 0 5">  </div>');
  progress_win.render(document.body);
  update_progress();
}
</script>

<script type="text/javascript">
<!--hide the progress meter unless a file is chosen.
    function toggle_visibility(id) {
       var e = document.getElementById(id);
       if(e.style.display == 'block')
          e.style.display = 'block';
       else
          e.style.display = 'block';
    }
//-->
</script>
</head> 
<body>
<div class="main_w">
  <br />
  <div class="content_n">
    <div class="memberBox">
      <h3>文件上传</h3>
    </div>
<?php
if (isset($_SESSION['success']))
{
?>
    <div class="box feedBox">
      <div class="feedTip min-succeed"><p>添加成功!</a></p></div>
    </div>
<?php
    unset($_SESSION['success']);
}
?>
    <div class="feedList">
      <div class="section">
        <div id="cont-reg" class="block login-form">
          <div class="pop-win-inner">
            <form id="contents" name="contents" action="" 
                  enctype="multipart/form-data" method="POST" 
                  onsubmit="postForm('old.php','contents');return false;">
              <input type="hidden" name="APC_UPLOAD_PROGRESS" id="progress_key" value="<?php echo uniqid()?>"/>
              <input type="hidden" name="max_file_size" value="2048000"> 
<?php
$i=1;
while($i<=$numfiles)
{
    $a=uniqid();
    $b=uniqid();
?>
              <div class="form-block">
              <label class="label">文件<?php echo $i?>：</label>
              <input name="file[<?php echo $a?>]" id="file[<?php echo $b?>]" 
                     class="form-default" type="file"
                     onclick="toggle_visibility('progress_win');"/>
              </div>
<?php
$i++;
}
?>
              <div class="block form-btn-block form-block form-content-block">
                <span class="btn-type-b btn-fn-c">
                  <!--a class="form-btn" href="javascript:document.getElementById('contents').submit()">上传</a-->
                  <input type="submit" class="form-btn" value="上传"/>
                </span>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="asider_n">
    <div class="box tools">
      <p>
        <form name="back" action="./incoming" method="post">
        </form>
        <span class="item itoolsStyle">
          <a class="B" href="javascript:document.back.submit();">已上传文件</a>
        </span>
      </p>
    </div>
  </div>
</div>
<div id="progress_win" style="display:none">
  <div class="hd" style="color: #333333; background: #D3D3D3"></div>
  <div class="bd"></div>
  <div class="ft"></div>
</div>
</body>
</html>
