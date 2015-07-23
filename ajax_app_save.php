<?php

include("inc/dbconnection.php");
$id = $_REQUEST['id'];
$value = $_REQUEST['value'];
$dis_res = $_REQUEST['dis_res'];


if ($value == 1) {
    $update = mysql_query("update mpc_leave_application set approved='$value',cancle_reason='$dis_res' where rec_id = '$id'");
    echo "<p style = 'color:green'>Leave Application Approved successfully</p>";
}
if ($value == 0) {
    $update = mysql_query("update mpc_leave_application set approved='$value',cancle_reason='$dis_res' where rec_id = '$id' ");
    echo "<p style='color:red'>Leave Application Canceled successfully</p>";
}
?>