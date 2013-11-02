<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
<title>Hw3</title>
<link href="../../style/SyntaxHighlighter.css" type="text/css" rel="stylesheet" />
<link href="css/style.css" type="text/css" rel="stylesheet"/>
<script type="text/javascript" src="../../share/dp.syntax/shCore.js"></script>
<script type="text/javascript" src="../../share/dp.syntax/shBrushJava.js"></script>
<script type="text/javascript">
    function loadSyntaxHighlighter ()
    {
        dp.SyntaxHighlighter.HighlightAll('code');
    }
    window.onload = loadSyntaxHighlighter;
</script>
<style type="text/css">
div.side
{
top:97px;
width:210px;
margin:0px 3px 0px 5px;
position:fixed;
padding: 5px 5px 5px 5px;
}
.hint
{
color:gray;    
}
</style>
</head>

<body>
<div class="container">
<div class="header"><h1>Parameter passing</h1></div>
<div class="wrap">
<div class="content"> 
    Parameter passed by static html code:<br />
    <div class="center">
    <applet codebase="applet" code="ParameterExample.class" width=300 height=300>
    <param name="alpha" value="1f" />
    </applet>
    <applet codebase="applet" code="ParameterExample.class" width=300 height=300>
    <param name="alpha" value="0.5f" />
    </applet>
    </div>
    SourceCode: 
    <textarea name="code" class="java:collapse" cols="60">
    <?php echo file_get_contents('applet/SimpleDraw.java'); ?> 
    </textarea>
</div>
<div class="side" style="left:4px;float:left"></div>
<div class="side" style="right:4px;float:right"></div>
</div>
<div class="footer">
<p>powered by Billy</p>
</div>
</div>
</body>
</html>
