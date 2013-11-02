<?php
include('dbconn.php');

$table=$_POST["table"];
$query="desc ".$table;
$result=mysql_query($query) or die(mysql_error());
$num_labels = mysql_num_rows($result);
echo "<tr>";
while($row=mysql_fetch_array($result))
{
    echo "<th>".$row[0]."</th>\n";
}
echo "</tr>";

$query="select * from ".$table;
$result=mysql_query($query) or die(mysql_error());
$num_lines = mysql_num_rows($result);
if ($num_lines==0)
{
    echo "<tr><td colspan='$num_labels'>Empty Set</td></tr>";
}
else
{
    while($row=mysql_fetch_array($result))
    {
        $id=$row[0];
        echo "<tr class='table_row' id='row_$id'>";
        for ($i=0; $i<$num_labels; $i++)
        {
            echo "<td>".$row[$i]."</td>\n";
        }
        echo "</tr>";
    }
}
mysql_free_result($result);
include('dbdisconn.php');
?>
