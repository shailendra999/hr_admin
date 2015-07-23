<?php

include ("inc/dbconnection.php");
include ("inc/function.php");
$txt_date1 = $_GET["id"];
$txt_date2 = $_GET["sdate"];
$id = $_GET["str"];
$status = $_POST["str4"];
$stat = $_POST["str4"];
$badli_as = $_POST["str5"];
$type = $_POST["str6"];
$shift = $_GET["str7"];

////////////////////// Markin attendence //////////////
$ip = $_SERVER['REMOTE_ADDR'];
$good_work = "";
$txt_date1 = str_replace("/", "-", $txt_date1);
$txt_date2 = str_replace("/", "-", $txt_date2);
$datePeriod = createDateRangeArray($txt_date2, $txt_date1);
date_default_timezone_set('UTC');
$date = $txt_date1;
// End date
$end_date = $txt_date2;

while (strtotime($date) <= strtotime($end_date)) {

    $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
}
$dayofweek = date('w', strtotime($date));
$result = date('Y-m-d', strtotime(($day - $dayofweek) . ' day', strtotime($date)));



foreach ($datePeriod as $datePeriod) {
    $weekoff = date('l', strtotime($datePeriod));
    $q = mysql_query("select off_day from mpc_shift_detail where emp_id ='$id'");
    $a = mysql_fetch_array($q);
    $off = $a['off_day'];
    if ($weekoff == $off) {
        $status = "w";
        $b = 1;
    }

//My code End here//


    $sql_check_attendance = "SELECT * FROM mpc_attendence_master where  date='$datePeriod' and emp_id ='$id'";
    $result_check_attendance = mysql_query($sql_check_attendance) or die("Error in : " . $sql_check_attendance . "<br>" . mysql_errno() . " : " . mysql_error());

    $asdf = mysql_num_rows($result_check_attendance);

    if ($asdf == 0) {
        $select = mysql_query("Select * From mpc_holiday_master where holiday_date = '$datePeriod' ");
        $q = mysql_num_rows($select);
        if ($q > 0) {
            $status = "HD";
            $a = "1";
        }

        $leave_query = mysql_query("Select * from mpc_leave_application where emp_id = '$id' ");
        $leave_rows = mysql_num_rows($leave_query);

        if ($leave_rows > 0) {


            while ($leave_res = mysql_fetch_array($leave_query)) {
                $dPeriod = date('m-d-Y', strtotime($datePeriod));
                $DateBegin = $leave_res['start_date'];
                $DateEnd = $leave_res['end_date'];
                if (($dPeriod >= $DateBegin) && ($dPeriod <= $DateEnd)) {
                    $lname = mysql_query("select * from mpc_leave_master where id = '$leave_res[leave_type]'");
                    $lres = mysql_fetch_array($lname);
                    $status = $lres['leave_name'];
                } else {
                    
                }
            }
        }
        $sql_check = "insert into " . $mysql_table_prefix . "attendence_master set emp_id ='$id',
			attendance_status='$status',
			date ='$datePeriod',
			badli_as ='$badli_as',
			shift ='$shift',
			good_work ='$good_work',
			InsertBy ='$id',
			InsertDate =now(),
			IpAddress ='$ip'";

        $result_check = mysql_query($sql_check) or die("Query Failed " . mysql_error());
        if ($a == 1) {
            $status = $_POST["str4"];
        }
    } else {
        $leave_query = mysql_query("Select * from mpc_leave_application where emp_id = '$id' ");
        $leave_rows = mysql_num_rows($leave_query);

        if ($leave_rows > 0) {


            while ($leave_res = mysql_fetch_array($leave_query)) {
                $dPeriod = date('m-d-Y', strtotime($datePeriod));
                $DateBegin = $leave_res['start_date'];
                $DateEnd = $leave_res['end_date'];
                if (($dPeriod >= $DateBegin) && ($dPeriod <= $DateEnd)) {
                    $lname = mysql_query("select * from mpc_leave_master where id = '$leave_res[leave_type]'");
                    $lres = mysql_fetch_array($lname);
                    $status = $lres['leave_name'];
                } else {
                    
                }
            }
        }
        $select = mysql_query("Select * From mpc_holiday_master where holiday_date = '$datePeriod' ");
        $q = mysql_num_rows($select);
        if ($q > 0) {
            $status = "HD";
            $a = "1";
        }
        $sql_check_update = "update " . $mysql_table_prefix . "attendence_master set	
			    attendance_status='$status',badli_as ='$badli_as',shift ='$shift'
                            where emp_id ='$id' and date ='$datePeriod'";
        $result_check_update = mysql_query($sql_check_update) or die("Query Failed " . mysql_error());
        if ($a == 1) {
            $status = $_POST["str4"];
        }
    }
    if ($b == "1") {
        $status = $_POST["str4"];
    }
}
die;
$q = mysql_query("select * from mpc_leave_application  where emp_id ='$id' and start_date  BETWEEN  '$txt_date2' AND '$txt_date1'");
$aa = mysql_num_rows($q);
$a = mysql_fetch_array($q);
$approved = $a['approved'];
$date1 = $a['start_date'];
$date2 = $a['end_date'];
$datePeriodl = createDateRangeArray($date1, $date2);
if ($aa > 0 && $approved == '1') {
    foreach ($datePeriodl as $datePeriodl) {
        $date_leave1 = $a['start_date'];
        $date_leave2 = $a['end_date'];
        $status = $a['leave_type'];

        $sql_check_update = "update " . $mysql_table_prefix . "attendence_master set	
				attendance_status='$status',
				badli_as ='$badli_as',
				shift ='$shift'
				where emp_id ='$id' and date ='$datePeriodl'";
        $result_check_update = mysql_query($sql_check_update) or die("Query Failed " . mysql_error());
    }
}

if (isset($_GET['start'])) {
    if ($_GET['start'] == 'All') {
        $start = 0;
    } else {
        $start = $_GET['start'];
    }
} else {
    $start = 0;
}

function createDateRangeArray($strDateFrom, $strDateTo) {
    $aryRange = array();
    $iDateFrom = mktime(1, 0, 0, substr($strDateFrom, 5, 2), substr($strDateFrom, 8, 2), substr($strDateFrom, 0, 4));
    $iDateTo = mktime(1, 0, 0, substr($strDateTo, 5, 2), substr($strDateTo, 8, 2), substr($strDateTo, 0, 4));
    if ($iDateTo >= $iDateFrom) {
        array_push($aryRange, date('Y-m-d', $iDateFrom)); // first entry
        while ($iDateFrom < $iDateTo) {
            $iDateFrom+=86400; // add 24 hours
            array_push($aryRange, date('Y-m-d', $iDateFrom));
        }
    }
    return $aryRange;
}
?>	


