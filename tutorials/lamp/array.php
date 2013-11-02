<?php
    error_reporting(E_ALL);

    // simplest one
    echo "(1)<br/>";
    $array = array(1, 2, 3, 4, 5);
    print_r($array);
    echo '<br /><br />';

    // try unset and reset, note that array will not be reindexed
    echo "(2)<br/>";
    foreach ($array as $i=>$value) {
        unset($array[$i]);
    }
    $array[]=6;
    print_r($array);
    echo '<br /><br />';

    // integer key is changed to string key?
    echo "(3)<br/>";
    $arr = array('foo' => 'bar', 12 => true);
    print_r($arr);
    echo '<br />';
    echo $arr['foo'].'<br />';
    echo $arr[12].'<br />';
    echo $arr['12'].'<br />';
    echo '<br />';

    // try keys
    echo "(4)<br/>";
    $keys=array_keys($arr);
    echo $keys.'<br />';
    echo $keys[0].'<br />';
    echo $keys[1].'<br />';
    echo '<br />';

    // mysql_fetch_array creates a special array
    echo "(5)<br/>";
    mysql_connect("localhost","se","se") or die("Could not connect database");
    mysql_select_db("meal") or die("Could not select database");
    $query="select * from user";
    $result=mysql_query($query) or die(mysql_error());
    $num_fields = mysql_num_fields($result);
    print_r(mysql_fetch_array($result));
    echo '<br /><br />';

    // two-dimension array, pay attention to the index of "holes"
    echo "(6)<br/>";
    $fruits = array( 
        "fruits"  => array("a" => "orange", "b" => "banana", "c" => "apple"),
        "numbers" => array(1, 2, 3, 4, 5, 6), 
        "holes"   => array("first", 5 => "second", "third", 'foo'=>'fourth', 'fifth'));
    print_r($fruits);
    echo '<br /><br />';


    // implode
    echo "(7)<br/>";
    $comma_seperated=implode(',',$arr);
    echo $comma_seperated;
    echo '<br /><br />';

    // explode 
    echo "(8)<br/>";
    $comma_seperated=implode(',',$arr);
    $new_arr=explode(',',$comma_seperated);
    print_r($new_arr);
    echo '<br /><br />';

    // sequential access
    echo "(9)<br/>";
    $mode = current($new_arr);
    echo $mode.'<br/>';
    $mode = next($new_arr);
    echo $mode.'<br/>';
    $mode = prev($new_arr);
    echo $mode.'<br/>';
    $mode = end($new_arr);
    echo $mode.'<br/>';
?>
