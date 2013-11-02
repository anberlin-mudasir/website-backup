<title>Scores for Cet-6 </title>
<h2>
Scores for Cet-6
<?php
$submit=null;
isset($_POST['submit']) && $submit=$_POST['submit'];
isset($_POST['score'])  && $score=$_POST['score'];
isset($_POST['piece'])  && $piece=$_POST['piece'];
if ($submit == "submit")
	echo "($piece per size)";
?>
<p>
<table class="font">
<?php
mysql_connect("localhost","root","chdyl,") or die("Could not connect to database");
mysql_select_db("cet6") or die("Could not select database");

echo "<style type=\"text/css\">table{float:left;}</style>";
echo "<style>.font{font-size:12px}</style>";

if ($submit == "submit")
{
	($piece<1 or $piece>40) and die("<h4>宽度输入有误!</h4>");
	($score<0 or $piece>710) and die("<h4>分数输入有误!</h4>");
	
	$query="select count(*), max(n) from score";
	$result=mysql_query($query) or die(mysql_error());
	$row=mysql_fetch_row($result);
	$total=$row[0];
	$max=$row[1];
	
	$query="select max(count) from (select n as score, count(n) as count from score group by n) as T";
	$result=mysql_query($query) or die(mysql_error());
	$row=mysql_fetch_row($result);
	$max_count=$row[0];
	
	$query="select n as score, count(n) as count from score group by n";
	$result=mysql_query($query) or die(mysql_error());
	
	echo "<table class=\"font\" border=0><tr valign=\"left\">";
	$lines=0;
	$size=0;
	$flag=0;
	while ($row = mysql_fetch_row($result)) 
	{
		while(($row[0]!=$max and $lines<=$row[0]) or ($row[0]==$max and $lines<=710))
		{
			if (($row[0]!=$max and $lines<$row[0]) or $row[0]==$max)
				;
			else
				$size+=$row[1];
				
			if (($lines % $piece == 0 and $lines >0) or $lines==710)
			{
				if ($size==0 && $flag==0)
				{
					$lines++;
					continue;
				}
				else
					$flag=1;
				$percent=($size/$total)*100;
				$width=($size/$max_count)*20;
				if ($lines-$piece <= $score && $score < $lines)
					$color="#E64696";
				else
					$color="#3F7F9F";
				echo "	  <table class =\"font\" width=\"".$width."\" border=0><td bgcolor=\"".$color."\"  height=8>\n";
				echo number_format($percent,1)."%";
				echo "</td></table>\n";
				echo "	  <table class=\"font\" width=10 border=0><td align=\"center\" height=8>\n";
				echo ($lines-$piece)."~".($lines-1);
				echo "</td></table><br />\n";
				$size=0;
			}
			$lines++;
		}
	}
	echo "  </tr></table>\n";
	mysql_free_result($result);
}
else
{
?>

<form action="scores.php" method="post">
<h4>输入您的六级分数:0~710:<br />
<input type="text" name="score" onkeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;">
<h4>输入所需显示分类的宽度:10~40:<br />
<input type="text" name="piece" onkeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;">
<br />
<input type="submit" name="submit" value="submit">
</h4>
</form>

<?php
}
mysql_close();
?>
<br />
<p>
