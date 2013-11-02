<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
<link href="../style/SyntaxHighlighter.css" type="text/css" rel="stylesheet" />
<link href="../style/hw.css" type="text/css" rel="stylesheet"/>
<link href="../style/style.css" type="text/css" rel="stylesheet"/>
<script type="text/javascript" src="../share/dp.syntax/shCore.js"></script>
<script type="text/javascript" src="../share/dp.syntax/shBrushJava.js"></script>
<script type="text/javascript" src="../share/dp.syntax/shBrushXml.js"></script>
<script type="text/javascript" src="../share/dp.syntax/shBrushPython.js"></script>
<script type="text/javascript">
    function loadSyntaxHighlighter ()
    {
        dp.SyntaxHighlighter.ClipboardSwf = '../share/dp.syntax/clipboard.swf';
        dp.SyntaxHighlighter.HighlightAll('code');
    }
    window.onload = loadSyntaxHighlighter;
</script>
<title>Han Jiang</title>
<script type="text/javascript" src="../share/prototype.lite.js"></script>
<script type="text/javascript" src="../share/moo.fx.js"></script>
<script type="text/javascript" src="../share/moo.fx.pack.js"></script>
<script type="text/javascript">
function init() {
    var gAccordion;
    var stretchers  = document.getElementsByClassName('stretcher');
    var toggles     = document.getElementsByClassName('display');
    gAccordion      = new fx.Accordion(toggles, stretchers, {opacity: true, duration: 300});
    gAccordion.hideAll();
}
</script>
</head>

<body>
<div id="page">
<div id="header">
<h2>
    <a id="homepage_link" href="">Han Jiang</a>:
    <a title="homework" href="../homework">homework</a>
</h2>
<script type="text/javascript" src="../share/menu.js"></script>
</div>

<div id="content">

<h2 id="null" class="display">
</h2>
<div class="stretcher"></div>

<h2 id="hw1">
    <a class="heading" href="http://162.105.203.19/wst/b2e2009/blogs/u/jianghan/index.php/2011/09/25/week1-homeworks"> Week 1: The Overview and fundamental</a>
</h2>

<h2 id="hw2">
<a class="heading" href='javascript:alert("Ah, this blog is already the hw2.")'> Week 2: Basic protocol I</a>
</h2>

<h2 id="hw3">
<a class="heading" href="hw3/index.html">Week 3: Basic protocol II</a>
</h2>

<h2 id="hw4" class="display">
<a class="heading" href="#hw4">Week 4: Access Database through Web</a>
</h2>
<div class="stretcher">
<?php include('hw4/index.php'); ?>
</div>

<h2 id="hw5" class="display">
<a class="heading" href="#hw5">Week 5: Java-An easy week </a>
</h2>
<div class="stretcher">
<?php include('hw5/index.php'); ?>
</div>

<h2 id="hw6" class="display">
<a class="heading" href="#hw6">Week 6: JavaScript-is not Java</a>
</h2>
<div class="stretcher">
<?php include('hw6/index.php'); ?>
</div>

<h2 id="hw7&8" class="display">
<a class="heading" href="#hw7&8">Week 7&8: Applets and Servlets</a>
</h2>
<div class="stretcher">
<?php include('hw7&8/index.php'); ?>
</div>

<h2 id="hw9" class="display">
<a class="heading" href="#hw9">Week 9: Web Log or Blog </a>
</h2>
<div class="stretcher">
<?php include('hw9/index.php'); ?>
</div>

<h2 id="hw10" class="display">
<a class="heading" href="#hw10">Week 10: XML, an overview</a>
</h2>
<div class="stretcher">
<?php include('hw10/index.php'); ?>
</div>


<div style="clear: both"></div>
</div>
<div id="footer"> </div>
<div id="smallprint">
<a class="ext" href="http://wikkawiki.org/">Powered by WikkaWiki</a>
</div>
</div>
</body>
<script type="text/javascript">
    init();
</script>
</html>
