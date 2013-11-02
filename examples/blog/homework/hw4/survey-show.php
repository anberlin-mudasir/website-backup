<?php
include('dbconn.php');

$query="desc survey";
$result=mysql_query($query) or die(mysql_error());
$num_labels = mysql_num_rows($result);
echo "<tr>";
while($row=mysql_fetch_array($result))
{
    echo "<th>".$row[0]."</th>\n";
}
echo "</tr>";

$query="select * from survey";
$result=mysql_query($query) or die(mysql_error());
$num_lines = mysql_num_rows($result);
if ($num_lines==0)
{
    echo "<tr><td colspan='$num_labels'>Empty Set</td></tr>";
}
else
{
    $cnt=0;
    while($row=mysql_fetch_array($result))
    {
        $id=$row[$num_labels-1];
        echo "<tr id='row_$id'>";
        for ($i=0; $i<$num_labels-1; $i++)
        {
            echo "<td>".$row[$i]."</td>\n";
        }
        echo "<td><input type=\"button\" class=\"x\" onclick=\"remove($id)\"/></td>";
        echo "</tr>";
        $cnt++;
    }
}
mysql_free_result($result);
include('dbdisconn.php');
?>
