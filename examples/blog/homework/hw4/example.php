<html>
<head>
<link href="../../style/style.css" type="text/css" rel="stylesheet"/>
<link href="../../style/hw.css" type="text/css" rel="stylesheet"/>
<script type="text/javascript">
function toggle() {
    if (document.getElementById("php").style.display=="none")
    {
        document.getElementById("php").style.display="block";
        document.getElementById("toggle").value="Hide Source";
    }
    else
    {
        document.getElementById("php").style.display="none";
        document.getElementById("toggle").value="View Source";
    }
}
</script>
</head>
<body>
<h3>Php result: </h3>
<div class="box">
<?php
include('show-column.php');
?>
</div>
<input id="toggle" type="button" value="View Source" onclick="toggle()"/>

<div id="php" style="display:none">
<h3>Php source-code:</h3>
<div id="phpsrc" class="box wikisource">
<?php
include('show-column-src.php');
?>
</div>
</div>

</body>
</html>
