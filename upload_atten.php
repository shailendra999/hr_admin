<?php

include("inc/dbconnection.php");

$i = 0;
$day = 1;
$month = $_REQUEST['month'];
$date = date('Y-' . $month . '-01');

$filename = $_FILES["attenace_imp"]["tmp_name"];
$row = 1;
if (($handle = fopen("$filename", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $num = count($data);
        $j = 0;
        $select = mysql_query("select emp_id from mpc_employee_master where ticket_no = '$data[0]'");
        $res = mysql_fetch_array($select);
        for ($i = 1; $i < $num; $i++) {
            $d = strtotime("+" . $j . "day", strtotime($date));
            $dates = date('Y-m-d', $d);
            $insert = mysql_query("INSERT into mpc_attendence_master(emp_id,attendance_status,date) values('$res[emp_id]','$data[$i]','$dates')");
            $j++;
        }
    }
}
header("location:atten.php");
?>		