<?php

$conn = @mysql_connect('localhost', 'ssofts_lss', 'ssoftslss')or die("Couldn't connect to server.");
$db = @mysql_select_db('ssofts_employee_common', $conn)or die("Couldn't select database.");
?>