<?php
$mysql_table_prefix = "mpc_";  
include ("settings.php");

$conn = @mysql_connect('localhost', 'root', '')or die("Couldn't connect to server.");
$db = @mysql_select_db('ssofts_lss', $conn)or die("Couldn't select database.");
?>
