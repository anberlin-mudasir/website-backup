<?php include('identicon.php') ?>

<html>
<head>

<script type="text/javascript">
function update() {
    update_link();
}
function update_link() {
    var query=document.getElementById('query').value;
    if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    } else {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function() {
        if (xmlhttp.readyState==4 && xmlhttp.status==200) {
            document.getElementById('link').href=xmlhttp.responseText;
            update_image(); // call as chain
        }
    }
    xmlhttp.open("POST","req.php",true);
    xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xmlhttp.send("query="+query+"&link=true");
}
function update_image() {
    var query=document.getElementById('query').value;
    if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    } else {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function() {
        if (xmlhttp.readyState==4 && xmlhttp.status==200) {
            document.getElementById('image').innerHTML=xmlhttp.responseText;
        }
    }
    xmlhttp.open("POST","req.php",true);
    xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xmlhttp.send("query="+query);
}
</script>

</head>
<body>

<form name="test" action="javascript:update()">
<strong>Input an id:</strong></br>
<input id="query" type="text" value="Götterdämmerung"/>
<input type="submit" value="Generate" />
</form>

<br/>
<p>A test identicon should be here:
<div id="image">
    <?php 
        $identicon=new identicon;
        echo $identicon->identicon_build('Götterdämmerung','[alt]');
    ?> 
</div>
</br>
And the source URL for image is 
<a href="<?php 
        echo $identicon->identicon_build('Götterdämmerung','[alt]',false);
?>"
   id="link" >here</a>.</p>

<a href="http://scott.sherrillmix.com/blog/blogger/wp_identicon/">WP_Identicon v1.02
</a> by 
<a href="http://scott.sherrillmix.com/blog/">scottsm</a>
</body>
</html>
