<?php

$con = @mysql_connect('localhost', 'ssofts_lss', 'ssoftslss')or die("Couldn't connect to server.");
$db = mysql_select_db('ssofts_adminlss', $con)or die("Couldn't select database.");
$val = $_REQUEST['id'];
//echo "UPDATE request SET edit_status='1' WHERE rec_id = '$val'";
mysql_query("UPDATE request SET edit_status='1' WHERE rec_id = '$val'");
?>