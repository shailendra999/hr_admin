<?php

function redirect($page_name) {
    echo "<script language='javascript'>";
    echo "document.location='" . $page_name . "';";
    echo "</script>";
}

/////////  change date format dd/mm/yyyy into yyyy/mm/dd ////////////////
function getdbDate($datetime) {
    /* $date = substr($datetime,0,2); 
      $month = substr($datetime,3,2);
      $year = substr($datetime,6,4);
      $time = substr($datetime,10);
     */

    $month = substr($datetime, 0, 2);
    $date = substr($datetime, 3, 2);
    $year = substr($datetime, 6, 4);
    $time = substr($datetime, 10);



    $getdbDate = $year . "/" . $date . "/" . $month;
//$getdbdate = $year."/".$month."/".$date;
    return $getdbDate;
}

////   My Function     //////
function getdbDate1($datetime) {
    $month = substr($datetime, 8, 2);
    $Date = substr($datetime, 5, 2);
    $year = substr($datetime, 0, 4);
    $time = substr($datetime, 10);

//$cars[]=array($Date,$month,$year);
    $getdbDate1 = explode(" ", $year . "-" . $month . "-" . $Date);
// echo "<pre>";
//print_r($getdbDate1);
    $year . "/" . $date . "/" . $month;
    return $getdbDate1;
}

////////
/////////************ CONVERT DATABASE FORMAT INTO DD/MM/YYYY FORMATE ******************///////////////
function getDatetime($datetime) {
    $date = substr($datetime, 8, 2);
    $month = substr($datetime, 5, 2);
    $year = substr($datetime, 0, 4);
    $time = substr($datetime, 10);

    $datetime = $date . "/" . $month . "/" . $year;

    return $datetime;
}

/////////  change date format dd/mm/yyyy into yyyymm/dd ////////////////
function getdbDateSepretoe($datetime) {
    $date = substr($datetime, 0, 2);
    $month = substr($datetime, 3, 2);
    $year = substr($datetime, 6, 4);
    $time = substr($datetime, 10);

    $getdbDateSepretoe = $year . "-" . $month . "-" . $date;

    return $getdbDateSepretoe;
}

function activation_mail($to, $sub, $from_mail, $url, $name, $site_url, $site_name) {
    $subject = $site_name . "   " . $sub;
    $body = '
				<html>
				<head>
				<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
				<title>Activation Mail</title>
				</head>
				
				<body style="font-size:13px; font-family:Tahoma; color:#333333;">
				<div style="background-color:#fbbf66; padding:10px; margin-top:10px; margin-left: 10px; margin-right: 10px">
					<strong style="font-family:Trebuchet MS; font-size:16px; color:#FFFFFF">
						<a href="' . $site_url . '" target="_blank" style="color:#FFFFFF; text-decoration:none">' . $site_name . '</a>
					</strong>
				</div>
				<div style="margin:10px; text-align:justify">
					Hello ' . $name . ',<br />
					
					<br />
					To confirm your email address and activate your registration with ' . $site_name . ', please click on the link below:<br /><br/>
					<a href="' . $url . '" style="font-family:Trebuchet MS; font-size:16px; color:#0033CC">Click Here To Confirm Your Account</a>
		<br /><br/>
					If you have any questions, please email: ' . $site_url . '
		<br />
					Thank you!
		
				<br /><br><br /><br>
				</div>
				<div style="background-color:#fbbf66; padding:10px; margin-top:10px; margin-left: 10px; margin-right: 10px">
					<strong style="font-family:Trebuchet MS; font-size:16px; color:#FFFFFF">
						<a href="' . $site_url . '" target="_blank" style="color:#FFFFFF; text-decoration:none">' . $site_name . '</a>
					</strong>
				</div>
				</body>
				</html>	
			';
    mail($to, $subject, $body, "From:" . $from_mail . "\nContent-Type: text/html; charset=iso-8859-1");
}

function logindetail_mail($to, $sub, $from_mail, $login_id, $password, $site_url, $site_name) {

    $subject = $site_name . "   " . $sub;

    $body = '<html>
				<head>
				<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
				<title>Forgot password</title>
				</head>
				<body style="font-size:13px; font-family:Tahoma; color:#333333;">
				<div style="border: 1px solid #C53304; background-color:#376092; padding:10px; margin-top:10px; margin-left: 10px; margin-right: 10px">
					<strong style="font-family:Trebuchet MS; font-size:16px; color:#FFFFFF">
						<a href="' . $site_url . '" target="_blank" style="color:#FFFFFF; text-decoration:none">' . $site_name . '</a>
					</strong>
				</div>
				<div>
					
					<br />
					<div style="padding-left:10px;">Your Login Information is as follows : <br/><br/>
					<strong>Login ID :</strong> ' . $login_id . '<br/><br/>
					<strong>Password :</strong> ' . $password . '<br/>
					</div>
				</div>	
				<div style="border: 1px solid #C53304; background-color:#376092; padding:10px; margin-top:10px; margin-left: 10px; margin-right: 10px">
					<strong style="font-family:Trebuchet MS; font-size:16px; color:#FFFFFF">
						<a href="' . $site_url . '" target="_blank" style="color:#FFFFFF; text-decoration:none">' . $site_name . '</a>
					</strong>
				</div>
				</body>
				</html>';


    mail($to, $subject, $body, "From:" . $from_mail . "\nContent-Type: text/html; charset=iso-8859-1");
}

///////////Get MM/DD/YYY date Format///////////
function getDateFormate($date) {
    $getDateFormate = "";
    if ($date != "") {
        $date = explode("-", $date);
        $date_year = explode(" ", $date[2]);
        $getDateFormate = $date[1] . "-" . $date_year[0] . "-" . $date[0];
    }
    return $getDateFormate;
}

function getLeave($emp_id, $leave_type) {
    $getLeave = 0;
    $sql = "SELECT count(*) as count FROM mpc_attendence_master where emp_id = $emp_id and attendance_status = '$leave_type'";
//echo $sql;
    $result = mysql_query($sql) or die("Error in : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());

    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {

            $getLeave = $row['count'];
        }
    }
    return $getLeave;
}

function getTakenLeave($emp_id, $data_date) {
    $getTakenLeave = "";
    $sql = "SELECT attendance_status FROM mpc_attendence_master where date='$data_date' and emp_id='$emp_id'";
//echo $sql;
    $result = mysql_query($sql) or die("Error in : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());

    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {

            $getTakenLeave = $row['attendance_status'];
        }
    }
    return $getTakenLeave;
}

function getLeavestatus($emp_id, $leave_type) {
    $getLeavestatus = '';
    $sql = "SELECT count(*) as count FROM mpc_attendence_master where emp_id = $emp_id and attendance_status= '$leave_type'";
//echo $sql;
    $result = mysql_query($sql) or die("Error in : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());

    if (mysql_num_rows($result) > 0) {

        while ($row = mysql_fetch_array($result)) {
            $count = $row['count'];
        }
    }

    return $count;
}

function getLeavestatusBydate($emp_id, $date) {

    $getLeavestatusBydate = '';
    $sql = "SELECT attendance_status FROM mpc_attendence_master where emp_id = $emp_id and date= '$date'";
//echo $sql."<br><br>";
    $result = mysql_query($sql) or die("Error in : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());

    if (mysql_num_rows($result) > 0) {

        while ($row = mysql_fetch_array($result)) {
            $getLeavestatusBydate = $row['attendance_status'];
        }
    }

    return $getLeavestatusBydate;
}

function dateDiff($dformat, $endDate, $beginDate) {
    $date_parts1 = explode($dformat, $beginDate);
    $date_parts2 = explode($dformat, $endDate);
    $start_date = gregoriantojd($date_parts1[0], $date_parts1[1], $date_parts1[2]);
    $end_date = gregoriantojd($date_parts2[0], $date_parts2[1], $date_parts2[2]);
    return $end_date - $start_date;
}

function dateDiffDB($dformat, $endDate, $beginDate) {
    $date_parts1 = explode($dformat, $beginDate);
    $date_parts2 = explode($dformat, $endDate);
    $start_date = gregoriantojd($date_parts1[1], $date_parts1[2], $date_parts1[0]);
    $end_date = gregoriantojd($date_parts2[1], $date_parts2[2], $date_parts2[0]);
    return $end_date - $start_date;
}

function getLeaveAllowed($field_name, $employe_type) {
    $getLeaveAllowed = "";
    $sql = "SELECT " . $field_name . " FROM mpc_setting where employee_type = '$employe_type'";
//echo $sql;
    $result = mysql_query($sql) or die("Error in : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());

    if (mysql_num_rows($result) > 0) {

        $row = mysql_fetch_array($result);
        $getLeaveAllowed = $row[$field_name];
    }

    return $getLeaveAllowed;
}

function getleavecheck($date, $emp_id) {
    $getleavecheck = "";
    $sql = "SELECT leave_type FROM mpc_leave_application where emp_id ='$emp_id' and leave_date='$date'";
    $result = mysql_query($sql) or die("Error in : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());

    if (mysql_num_rows($result) > 0) {
        $row = mysql_fetch_array($result);
        $getleavecheck = $row['leave_type'];
    }

    return $getleavecheck;
}

function resize_image($file, $width, $height, $proportional = true, $output = 'file', $delete_original = false, $use_linux_commands = false) {
    if ($height <= 0 && $width <= 0) {
        return false;
    }
    $info = getimagesize($file);
    $image = '';
    $final_width = 0;
    $final_height = 0;
    list($width_old, $height_old) = $info;
    if ($proportional == 'false') {
        if ($width == 0)
            $factor = $height / $height_old;
        elseif ($height == 0)
            $factor = $width / $width_old;
        else
            $factor = min($width / $width_old, $height / $height_old);
        $final_width = round($width_old * $factor);
        $final_height = round($height_old * $factor);
    }
    else {
        $final_width = ( $width <= 0 ) ? $width_old : $width;
        $final_height = ( $height <= 0 ) ? $height_old : $height;
    }
    switch ($info[2]) {
        case IMAGETYPE_GIF:
            $image = imagecreatefromgif($file);
            break;
        case IMAGETYPE_JPEG:
            $image = imagecreatefromjpeg($file);
            break;
        case IMAGETYPE_PNG:
            $image = imagecreatefrompng($file);
            break;
        default:
            return false;
    }
    $image_resized = imagecreatetruecolor($final_width, $final_height);
    if (($info[2] == IMAGETYPE_GIF) || ($info[2] == IMAGETYPE_PNG)) {
        $trnprt_indx = imagecolortransparent($image);
    }
    imagecopyresampled($image_resized, $image, 0, 0, 0, 0, $final_width, $final_height, $width_old, $height_old);
    if ($delete_original == 'true') {
        if ($use_linux_commands)
            exec('rm ' . $file);
        else
            @unlink($file);
    }
    switch (strtolower($output)) {
        case 'browser':
            $mime = image_type_to_mime_type($info[2]);
            header("Content-type: $mime");
            $output = NULL;
            break;
        case 'file':
            $output = $file;
            break;
        case 'return':
            return $image_resized;
            break;
        default:
            $output = $output;
            break;
    }

    switch ($info[2]) {
        case IMAGETYPE_GIF:
            imagegif($image_resized, $output);
            break;
        case IMAGETYPE_JPEG:
            imagejpeg($image_resized, $output, 500);
            break;
        case IMAGETYPE_PNG:
            imagepng($image_resized, $output);
            break;
        default:
            return false;
    }
    return true;
}

function getHoliday($field_name, $date) {
    $getHoliday = "";
    $sql = "SELECT " . $field_name . " FROM mpc_holiday_master where holiday_date = '$date'";
//echo $sql;
    $result = mysql_query($sql) or die("Error in : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());

    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $getHoliday.= $row[$field_name] . "-";
        }
    }
    $getHoliday = rtrim($getHoliday, "-");
    return $getHoliday;
}

function getemployeeDetail($field_name, $emp_id) {
    $getemployeeDetail = "";
    $sql = "SELECT " . $field_name . " FROM mpc_employee_master where rec_id = '$emp_id'";
//echo $sql;
    $result = mysql_query($sql) or die("Error in : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());

    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $getemployeeDetail.= $row[$field_name];
        }
    }
    return $getemployeeDetail;
}

function getfamilyDetail($field_name, $emp_id) {
    $getfamilyDetail = "";
    $sql = "SELECT " . $field_name . " FROM mpc_family_master where emp_id = '$emp_id'";
//echo $sql;
    $result = mysql_query($sql) or die("Error in : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());

    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $getfamilyDetail.= $row[$field_name];
        }
    }
    return $getfamilyDetail;
}

function getofficeDetail($field_name, $emp_id) {
    $getofficeDetail = "";
    $sql = "SELECT " . $field_name . " FROM mpc_official_detail where emp_id = '$emp_id'";
//echo $sql;
    $result = mysql_query($sql) or die("Error in : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());

    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $getofficeDetail.= $row[$field_name];
        }
    }
    return $getofficeDetail;
}

function getShiftDetail($field_name, $emp_id) {
    $getShiftDetail = "";
    $sql = "SELECT " . $field_name . " FROM mpc_shift_detail where emp_id = '$emp_id' and to_date='0000-00-00'";
//echo $sql;
    $result = mysql_query($sql) or die("Error in : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());

    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $getShiftDetail.= $row[$field_name];
        }
    }
    return $getShiftDetail;
}

function getAccountDetail($field_name, $emp_id) {
    $getShiftDetail = "";
    $sql = "SELECT " . $field_name . " FROM mpc_account_detail where emp_id = '$emp_id'";
//echo $sql;
    $result = mysql_query($sql) or die("Error in : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());

    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $getShiftDetail.= $row[$field_name];
        }
    }
    return $getShiftDetail;
}

function getGoodWorkBydate($emp_id, $date) {

    $getGoodWorkBydate = '';
    $total_gw = "";
    $good_work_min = "";
    $good_work_hour = "";
    $sql = "SELECT good_work FROM mpc_good_work_master where emp_id = $emp_id and date= '$date'";
//echo $sql;
    $result = mysql_query($sql) or die("Error in : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());

    if (mysql_num_rows($result) > 0) {
        $total_gw = "";
        while ($row = mysql_fetch_array($result)) {
            $getGoodWorkBydate = $row['good_work'];
            if ($getGoodWorkBydate != "") {

                $good_work_array = explode(':', $getGoodWorkBydate);

                $good_work_min = $good_work_min + $good_work_array[1];

                $good_work_hour = $good_work_hour + $good_work_array[0];

                if ($good_work_min == 60) {
                    $good_work_hour = $good_work_hour + 1;

                    $good_work_min = 0;
                }
                if ($good_work_min == 0) {
                    $good_work_min = "00";
                }
                $total_gw = $good_work_hour . ":" . $good_work_min;
            }
        }
    }

    return $total_gw;
}

function getleavecountMonthly($emp_id, $leave_type, $month, $year) {
    $end_date = date("t", strtotime($year . "-" . $month . "-01"));
    $start_date = "01";

    $date_start = $year . "-" . $month . "-" . $start_date;
    $date_end = $year . "-" . $month . "-" . $end_date;

    $getleavecountMonthly = '';
    $sql = "SELECT count(*) as count FROM mpc_attendence_master where emp_id = $emp_id and attendance_status= '$leave_type' and date between '" . $date_start . "' and '" . $date_end . "'";
//echo $sql;
    $result = mysql_query($sql) or die("Error in : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());

    if (mysql_num_rows($result) > 0) {

        while ($row = mysql_fetch_array($result)) {
            $count = $row['count'];
        }
    }

    return $count;
}

function getSalaryDetail($field_name, $emp_id, $date) {
    $getSalaryDetail = "";
    $sql_to = "SELECT " . $field_name . " FROM mpc_salary_master where emp_id = '$emp_id' and from_date<='$date' and '$date'<=to_date and to_date!='0000-00-00'";
//echo $sql;
    $result_to = mysql_query($sql_to) or die("Error in : " . $sql_to . "<br>" . mysql_errno() . " : " . mysql_error());

    if (mysql_num_rows($result_to) > 0) {
        while ($row = mysql_fetch_array($result_to)) {
            $getSalaryDetail = $row[$field_name];
        }
    }

    $sql_to = "SELECT " . $field_name . " FROM mpc_salary_master where emp_id = '$emp_id' and from_date<='$date' and to_date='0000-00-00'";
//echo $sql;
    $result_to = mysql_query($sql_to) or die("Error in : " . $sql_to . "<br>" . mysql_errno() . " : " . mysql_error());

    if (mysql_num_rows($result_to) > 0) {
        while ($row = mysql_fetch_array($result_to)) {
            $month = substr($date, 5, 2);
            $getSalaryDetail = $row[$field_name];
        }
    }
    return $getSalaryDetail;
}

function PLeave($emp_id, $date, $status) {
    $pl_start_date = "";
    $sql_att = "SELECT * FROM mpc_attendence_master where emp_id = '$emp_id' and date='$date' and attendance_status='$status'";
    $result_att = mysql_query($sql_att) or die("Error in : " . $sql_att . "<br>" . mysql_errno() . " : " . mysql_error());

    if (mysql_num_rows($result_att) > 0) {
        $row = mysql_fetch_array($result_att);
        $pl_start_date = $row['date'];
        $date1 = substr($pl_start_date, 8, 2);
        $month = substr($pl_start_date, 5, 2);
        $year = substr($pl_start_date, 0, 4);
        $pl_start_date = $pl_start_date;
    }

    return $pl_start_date;
}

function getDepartment($dept, $date, $status, $skill_level, $shift) {
    $getDepartment = "";

    $sql_att = "SELECT count(*) as Count FROM mpc_designation_master,mpc_department_employee,mpc_shift_detail,mpc_attendence_master,mpc_designation_employee where mpc_department_employee.emp_id=mpc_shift_detail.emp_id and mpc_department_employee.emp_id=mpc_attendence_master.emp_id and mpc_shift_detail.emp_id=mpc_department_employee.emp_id and mpc_designation_employee.emp_id=mpc_attendence_master.emp_id and mpc_department_employee.dept_id  = '$dept' and '$date'>=mpc_department_employee.from_date and (mpc_department_employee.to_date ='0000-00-00' or mpc_department_employee.to_date >='$date') and mpc_attendence_master.attendance_status like '%$status%' and mpc_attendence_master.date='$date' and mpc_designation_employee.designation_id like '%$skill_level%' and '$date'>=mpc_designation_employee.from_date and (mpc_designation_employee.to_date ='0000-00-00' or mpc_designation_employee.to_date >='$date') and mpc_shift_detail.shift like '%$shift%' and (mpc_shift_detail.to_date ='0000-00-00' or mpc_shift_detail.to_date >='$date') and mpc_designation_employee.designation_id=mpc_designation_master.rec_id and mpc_designation_master.emp_category='Worker'";

    /* $sql_att = "SELECT count(*) as Count FROM mpc_department_employee,mpc_shift_detail,mpc_attendence_master,mpc_skill_employee where mpc_department_employee.emp_id=mpc_shift_detail.emp_id and mpc_department_employee.emp_id=mpc_attendence_master.emp_id and mpc_shift_detail.emp_id=mpc_department_employee.emp_id and mpc_skill_employee.emp_id=mpc_attendence_master.emp_id and mpc_department_employee.dept_id  = '$dept' and '$date'>=mpc_department_employee.from_date and  '$date'<= mpc_department_employee.to_date 
      and mpc_skill_employee.skill_id like '$skill_level' and '$date'>= mpc_shift_detail.from_date and '$date'<= mpc_shift_detail.to_date and mpc_shift_detail.shift like '%$shift%' and mpc_attendence_master.date like '$date' and mpc_attendence_master.attendance_status like '$status'"; */

    /* SELECT count(*) as Count FROM mpc_official_detail,mpc_shift_detail,mpc_attendence_master where mpc_official_detail.emp_id=mpc_shift_detail.emp_id and mpc_official_detail.emp_id=mpc_attendence_master.emp_id and mpc_official_detail.department = '3' and mpc_official_detail.skill_level = 'Skill' and '2010-04-08'>= mpc_shift_detail.from_date and '2010-04-08'<= mpc_shift_detail.to_date and mpc_shift_detail.shift like 'First' and mpc_attendence_master.date='2010-04-08' and mpc_attendence_master.attendance_status ='P' */
    $result_att = mysql_query($sql_att) or die("Error in : " . $sql_att . "<br>" . mysql_errno() . " : " . mysql_error());

    if (mysql_num_rows($result_att) > 0) {
        $row = mysql_fetch_array($result_att);
        $getDepartment = $row ['Count'];
    }

    return $getDepartment;
}

function getGoodWorkDept($dept, $date, $skill_level, $shift) {
    $getGoodWorkDept = "";

    $sql_att = "SELECT count(*) as Count FROM mpc_designation_master,mpc_department_employee,mpc_shift_detail,mpc_good_work_master,mpc_designation_employee where mpc_department_employee.emp_id=mpc_shift_detail.emp_id and mpc_department_employee.emp_id=mpc_good_work_master.emp_id and mpc_shift_detail.emp_id=mpc_department_employee.emp_id and mpc_designation_employee.emp_id=mpc_good_work_master.emp_id and mpc_department_employee.dept_id  = '$dept' and '$date'>=mpc_department_employee.from_date and (mpc_department_employee.to_date ='0000-00-00' or mpc_department_employee.to_date >='$date') and mpc_good_work_master.date='$date' and mpc_designation_employee.designation_id like '%$skill_level%' and '$date'>=mpc_designation_employee.from_date and (mpc_designation_employee.to_date ='0000-00-00' or mpc_designation_employee.to_date >='$date') and mpc_shift_detail.shift like '%$shift%' and (mpc_shift_detail.to_date ='0000-00-00' or mpc_shift_detail.to_date >='$date') and mpc_designation_employee.designation_id=mpc_designation_master.rec_id and mpc_designation_master.emp_category='Worker'";

    /* $sql_att = "SELECT count(*) as Count FROM mpc_department_employee,mpc_shift_detail,mpc_attendence_master,mpc_skill_employee where mpc_department_employee.emp_id=mpc_shift_detail.emp_id and mpc_department_employee.emp_id=mpc_attendence_master.emp_id and mpc_shift_detail.emp_id=mpc_department_employee.emp_id and mpc_skill_employee.emp_id=mpc_attendence_master.emp_id and mpc_department_employee.dept_id  = '$dept' and '$date'>=mpc_department_employee.from_date and  '$date'<= mpc_department_employee.to_date 
      and mpc_skill_employee.skill_id like '$skill_level' and '$date'>= mpc_shift_detail.from_date and '$date'<= mpc_shift_detail.to_date and mpc_shift_detail.shift like '%$shift%' and mpc_attendence_master.date like '$date' and mpc_attendence_master.attendance_status like '$status'"; */

    /* SELECT count(*) as Count FROM mpc_official_detail,mpc_shift_detail,mpc_attendence_master where mpc_official_detail.emp_id=mpc_shift_detail.emp_id and mpc_official_detail.emp_id=mpc_attendence_master.emp_id and mpc_official_detail.department = '3' and mpc_official_detail.skill_level = 'Skill' and '2010-04-08'>= mpc_shift_detail.from_date and '2010-04-08'<= mpc_shift_detail.to_date and mpc_shift_detail.shift like 'First' and mpc_attendence_master.date='2010-04-08' and mpc_attendence_master.attendance_status ='P' */
    $result_att = mysql_query($sql_att) or die("Error in : " . $sql_att . "<br>" . mysql_errno() . " : " . mysql_error());

    if (mysql_num_rows($result_att) > 0) {
        $row = mysql_fetch_array($result_att);
        $getGoodWorkDept = $row ['Count'];
    }

    return $getGoodWorkDept;
}

function getDepartmentByMainDeptId($dept, $date, $status, $skill_level, $shift) {
    $getDepartmentByMainDeptId = 0;

    $sql = "SELECT rec_id FROM mpc_department_master where reference_id = '" . $dept . "'";
    $result = mysql_query($sql) or die("Error in : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row_sub = mysql_fetch_array($result)) {
            $sql_att = "SELECT count(*) as Count FROM mpc_department_employee,mpc_shift_detail,mpc_attendence_master,mpc_designation_employee where mpc_department_employee.emp_id=mpc_shift_detail.emp_id and mpc_department_employee.emp_id=mpc_attendence_master.emp_id and mpc_shift_detail.emp_id=mpc_department_employee.emp_id and mpc_designation_employee.emp_id=mpc_attendence_master.emp_id and mpc_department_employee.dept_id  = '" . $row_sub['rec_id'] . "' and '$date'>=mpc_department_employee.from_date and (mpc_department_employee.to_date ='0000-00-00' or mpc_department_employee.to_date >='$date') and mpc_attendence_master.attendance_status like '%$status%' and mpc_attendence_master.date='$date' and mpc_designation_employee.designation_id like '%$skill_level%' and '$date'>=mpc_designation_employee.from_date and (mpc_designation_employee.to_date ='0000-00-00' or mpc_designation_employee.to_date >='$date') and mpc_shift_detail.shift like '%$shift%' and (mpc_shift_detail.to_date ='0000-00-00' or mpc_shift_detail.to_date >='$date')";

            /* $sql_att = "SELECT count(*) as Count FROM mpc_department_employee,mpc_shift_detail,mpc_attendence_master,mpc_skill_employee where mpc_department_employee.emp_id=mpc_shift_detail.emp_id and mpc_department_employee.emp_id=mpc_attendence_master.emp_id and mpc_shift_detail.emp_id=mpc_department_employee.emp_id and mpc_skill_employee.emp_id=mpc_attendence_master.emp_id and mpc_department_employee.dept_id  = '$dept' and '$date'>=mpc_department_employee.from_date and  '$date'<= mpc_department_employee.to_date 
              and mpc_skill_employee.skill_id like '$skill_level' and '$date'>= mpc_shift_detail.from_date and '$date'<= mpc_shift_detail.to_date and mpc_shift_detail.shift like '%$shift%' and mpc_attendence_master.date like '$date' and mpc_attendence_master.attendance_status like '$status'"; */

            /* SELECT count(*) as Count FROM mpc_official_detail,mpc_shift_detail,mpc_attendence_master where mpc_official_detail.emp_id=mpc_shift_detail.emp_id and mpc_official_detail.emp_id=mpc_attendence_master.emp_id and mpc_official_detail.department = '3' and mpc_official_detail.skill_level = 'Skill' and '2010-04-08'>= mpc_shift_detail.from_date and '2010-04-08'<= mpc_shift_detail.to_date and mpc_shift_detail.shift like 'First' and mpc_attendence_master.date='2010-04-08' and mpc_attendence_master.attendance_status ='P' */
            $result_att = mysql_query($sql_att) or die("Error in : " . $sql_att . "<br>" . mysql_errno() . " : " . mysql_error());

            if (mysql_num_rows($result_att) > 0) {
                $row_1 = mysql_fetch_array($result_att);
                $getDepartmentByMainDeptId = $getDepartmentByMainDeptId + $row_1['Count'];
            }
        }
    }

    return $getDepartmentByMainDeptId;
}

function getDepartmentByMainDeptIdSum($date, $status, $skill_level, $shift) {
    $getDepartmentByMainDeptId = 0;

    $sql = "SELECT rec_id FROM mpc_department_master";
    $result = mysql_query($sql) or die("Error in : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row_sub = mysql_fetch_array($result)) {
            $sql_att = "SELECT count(*) as Count FROM mpc_department_employee,mpc_shift_detail,mpc_attendence_master,mpc_designation_employee where mpc_department_employee.emp_id=mpc_shift_detail.emp_id and mpc_department_employee.emp_id=mpc_attendence_master.emp_id and mpc_shift_detail.emp_id=mpc_department_employee.emp_id and mpc_designation_employee.emp_id=mpc_attendence_master.emp_id and mpc_department_employee.dept_id  = '" . $row_sub['rec_id'] . "' and '$date'>=mpc_department_employee.from_date and (mpc_department_employee.to_date ='0000-00-00' or mpc_department_employee.to_date >='$date') and mpc_attendence_master.attendance_status like '%$status%' and mpc_attendence_master.date='$date' and mpc_designation_employee.designation_id like '%$skill_level%' and '$date'>=mpc_designation_employee.from_date and (mpc_designation_employee.to_date ='0000-00-00' or mpc_designation_employee.to_date >='$date') and mpc_shift_detail.shift like '%$shift%' and (mpc_shift_detail.to_date ='0000-00-00' or mpc_shift_detail.to_date >='$date')";

            /* $sql_att = "SELECT count(*) as Count FROM mpc_department_employee,mpc_shift_detail,mpc_attendence_master,mpc_skill_employee where mpc_department_employee.emp_id=mpc_shift_detail.emp_id and mpc_department_employee.emp_id=mpc_attendence_master.emp_id and mpc_shift_detail.emp_id=mpc_department_employee.emp_id and mpc_skill_employee.emp_id=mpc_attendence_master.emp_id and mpc_department_employee.dept_id  = '$dept' and '$date'>=mpc_department_employee.from_date and  '$date'<= mpc_department_employee.to_date 
              and mpc_skill_employee.skill_id like '$skill_level' and '$date'>= mpc_shift_detail.from_date and '$date'<= mpc_shift_detail.to_date and mpc_shift_detail.shift like '%$shift%' and mpc_attendence_master.date like '$date' and mpc_attendence_master.attendance_status like '$status'"; */

            /* SELECT count(*) as Count FROM mpc_official_detail,mpc_shift_detail,mpc_attendence_master where mpc_official_detail.emp_id=mpc_shift_detail.emp_id and mpc_official_detail.emp_id=mpc_attendence_master.emp_id and mpc_official_detail.department = '3' and mpc_official_detail.skill_level = 'Skill' and '2010-04-08'>= mpc_shift_detail.from_date and '2010-04-08'<= mpc_shift_detail.to_date and mpc_shift_detail.shift like 'First' and mpc_attendence_master.date='2010-04-08' and mpc_attendence_master.attendance_status ='P' */
            $result_att = mysql_query($sql_att) or die("Error in : " . $sql_att . "<br>" . mysql_errno() . " : " . mysql_error());

            if (mysql_num_rows($result_att) > 0) {
                $row_1 = mysql_fetch_array($result_att);
                $getDepartmentByMainDeptId = $getDepartmentByMainDeptId + $row_1['Count'];
            }
        }
    }

    return $getDepartmentByMainDeptId;
}

function getGoodWorkByMainDeptId($dept, $date, $skill_level, $shift) {
    $getGoodWorkByMainDeptId = 0;

    $sql = "SELECT rec_id FROM mpc_department_master where reference_id = '" . $dept . "'";
    $result = mysql_query($sql) or die("Error in : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row_sub = mysql_fetch_array($result)) {
            $sql_att = "SELECT count(*) as Count FROM mpc_department_employee,mpc_shift_detail,mpc_good_work_master,mpc_designation_employee where mpc_department_employee.emp_id=mpc_shift_detail.emp_id and mpc_department_employee.emp_id=mpc_good_work_master.emp_id and mpc_shift_detail.emp_id=mpc_department_employee.emp_id and mpc_designation_employee.emp_id=mpc_good_work_master.emp_id and mpc_department_employee.dept_id  = '" . $row_sub['rec_id'] . "' and '$date'>=mpc_department_employee.from_date and (mpc_department_employee.to_date ='0000-00-00' or mpc_department_employee.to_date >='$date') and mpc_good_work_master.date='$date' and mpc_designation_employee.designation_id like '%$skill_level%' and '$date'>=mpc_designation_employee.from_date and (mpc_designation_employee.to_date ='0000-00-00' or mpc_designation_employee.to_date >='$date') and mpc_shift_detail.shift like '%$shift%' and (mpc_shift_detail.to_date ='0000-00-00' or mpc_shift_detail.to_date >='$date')";

            /* $sql_att = "SELECT count(*) as Count FROM mpc_department_employee,mpc_shift_detail,mpc_attendence_master,mpc_skill_employee where mpc_department_employee.emp_id=mpc_shift_detail.emp_id and mpc_department_employee.emp_id=mpc_attendence_master.emp_id and mpc_shift_detail.emp_id=mpc_department_employee.emp_id and mpc_skill_employee.emp_id=mpc_attendence_master.emp_id and mpc_department_employee.dept_id  = '$dept' and '$date'>=mpc_department_employee.from_date and  '$date'<= mpc_department_employee.to_date 
              and mpc_skill_employee.skill_id like '$skill_level' and '$date'>= mpc_shift_detail.from_date and '$date'<= mpc_shift_detail.to_date and mpc_shift_detail.shift like '%$shift%' and mpc_attendence_master.date like '$date' and mpc_attendence_master.attendance_status like '$status'"; */

            /* SELECT count(*) as Count FROM mpc_official_detail,mpc_shift_detail,mpc_attendence_master where mpc_official_detail.emp_id=mpc_shift_detail.emp_id and mpc_official_detail.emp_id=mpc_attendence_master.emp_id and mpc_official_detail.department = '3' and mpc_official_detail.skill_level = 'Skill' and '2010-04-08'>= mpc_shift_detail.from_date and '2010-04-08'<= mpc_shift_detail.to_date and mpc_shift_detail.shift like 'First' and mpc_attendence_master.date='2010-04-08' and mpc_attendence_master.attendance_status ='P' */
            $result_att = mysql_query($sql_att) or die("Error in : " . $sql_att . "<br>" . mysql_errno() . " : " . mysql_error());

            if (mysql_num_rows($result_att) > 0) {
                $row_1 = mysql_fetch_array($result_att);
                $getGoodWorkByMainDeptId = $getGoodWorkByMainDeptId + $row_1['Count'];
            }
        }
    }

    return $getGoodWorkByMainDeptId;
}

function getGoodWorkByMainDeptIdSum($date, $skill_level, $shift) {
    $getGoodWorkByMainDeptId = 0;

    $sql = "SELECT rec_id FROM mpc_department_master";
    $result = mysql_query($sql) or die("Error in : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row_sub = mysql_fetch_array($result)) {
            $sql_att = "SELECT count(*) as Count FROM mpc_department_employee,mpc_shift_detail,mpc_good_work_master,mpc_designation_employee where mpc_department_employee.emp_id=mpc_shift_detail.emp_id and mpc_department_employee.emp_id=mpc_good_work_master.emp_id and mpc_shift_detail.emp_id=mpc_department_employee.emp_id and mpc_designation_employee.emp_id=mpc_good_work_master.emp_id and mpc_department_employee.dept_id  = '" . $row_sub['rec_id'] . "' and '$date'>=mpc_department_employee.from_date and (mpc_department_employee.to_date ='0000-00-00' or mpc_department_employee.to_date >='$date') and mpc_good_work_master.date='$date' and mpc_designation_employee.designation_id like '%$skill_level%' and '$date'>=mpc_designation_employee.from_date and (mpc_designation_employee.to_date ='0000-00-00' or mpc_designation_employee.to_date >='$date') and mpc_shift_detail.shift like '%$shift%' and (mpc_shift_detail.to_date ='0000-00-00' or mpc_shift_detail.to_date >='$date')";

            /* $sql_att = "SELECT count(*) as Count FROM mpc_department_employee,mpc_shift_detail,mpc_attendence_master,mpc_skill_employee where mpc_department_employee.emp_id=mpc_shift_detail.emp_id and mpc_department_employee.emp_id=mpc_attendence_master.emp_id and mpc_shift_detail.emp_id=mpc_department_employee.emp_id and mpc_skill_employee.emp_id=mpc_attendence_master.emp_id and mpc_department_employee.dept_id  = '$dept' and '$date'>=mpc_department_employee.from_date and  '$date'<= mpc_department_employee.to_date 
              and mpc_skill_employee.skill_id like '$skill_level' and '$date'>= mpc_shift_detail.from_date and '$date'<= mpc_shift_detail.to_date and mpc_shift_detail.shift like '%$shift%' and mpc_attendence_master.date like '$date' and mpc_attendence_master.attendance_status like '$status'"; */

            /* SELECT count(*) as Count FROM mpc_official_detail,mpc_shift_detail,mpc_attendence_master where mpc_official_detail.emp_id=mpc_shift_detail.emp_id and mpc_official_detail.emp_id=mpc_attendence_master.emp_id and mpc_official_detail.department = '3' and mpc_official_detail.skill_level = 'Skill' and '2010-04-08'>= mpc_shift_detail.from_date and '2010-04-08'<= mpc_shift_detail.to_date and mpc_shift_detail.shift like 'First' and mpc_attendence_master.date='2010-04-08' and mpc_attendence_master.attendance_status ='P' */
            $result_att = mysql_query($sql_att) or die("Error in : " . $sql_att . "<br>" . mysql_errno() . " : " . mysql_error());

            if (mysql_num_rows($result_att) > 0) {
                $row_1 = mysql_fetch_array($result_att);
                $getGoodWorkByMainDeptId = $getGoodWorkByMainDeptId + $row_1['Count'];
            }
        }
    }

    return $getGoodWorkByMainDeptId;
}

function getDeptAttendancestatus($dept_id, $att_status, $date) {
    $getDeptAttendancestatus = 0;
    $sql = "SELECT emp_id FROM mpc_department_employee where dept_id  = '$dept_id'";
//echo $sql;
    $result = mysql_query($sql) or die("Error in : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());

    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $status = getLeavestatusBydate($row['emp_id'], $date);
            if ($status == $att_status) {
                $getDeptAttendancestatus++;
            }
        }
    }
    return $getDeptAttendancestatus;
}

function getdeptbyempid($emp_id, $date) {

    $getdeptbyempid = '';
    $sql = "SELECT dept_id FROM mpc_department_employee where emp_id = $emp_id and from_date <= '$date' and to_date >= '$date' ";
//echo $sql;
    $result = mysql_query($sql) or die("Error in : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());

    if (mysql_num_rows($result) > 0) {

        while ($row = mysql_fetch_array($result)) {
            $getdeptbyempid = $row['dept_id'];
        }
    }

    return $getdeptbyempid;
}

function getdesignationibyempid($emp_id, $date) {

    $getdesignationibyempid = '';
    $sql = "SELECT designation_id FROM mpc_designation_employee where emp_id = $emp_id and from_date <= '$date' and to_date >= '$date' ";
//echo $sql;
    $result = mysql_query($sql) or die("Error in : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());

    if (mysql_num_rows($result) > 0) {

        while ($row = mysql_fetch_array($result)) {
            $getdesignationibyempid = $row['designation_id'];
        }
    }

    return $getdesignationibyempid;
}

function getdeptDetail($FieldName, $WhereFieldName, $WhereValue) {
    $getdeptDetail = "";
    $sql = "SELECT " . $FieldName . " FROM mpc_department_master where " . $WhereFieldName . " = '" . $WhereValue . "' ";
    $result = mysql_query($sql) or die("Error in : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());
    
    if (mysql_num_rows($result) > 0) {
        $row = mysql_fetch_array($result);
        $getdeptDetail = $row[$FieldName];
    } else {
        $getdeptDetail = "Master";
    }
    return $getdeptDetail;
}

function checkDeptInDept($WhereValue) {
    $checkDeptInDept = false;
    $sql = "SELECT count(*) as Count FROM mpc_department_master where reference_id = '" . $WhereValue . "'";
    $result = mysql_query($sql) or die("Error in : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());
    $row = mysql_fetch_array($result);
    if ($row['Count'] == 0) {
        $checkDeptInDept = true;
    }


    return $checkDeptInDept;
}

function checkDeptMaster($WhereValue) {
    $checkDeptMaster = false;
    $sql = "SELECT count(*) as Count FROM mpc_department_employee where dept_id  = '" . $WhereValue . "'";
    $result = mysql_query($sql) or die("Error in : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());
    $row = mysql_fetch_array($result);
    if ($row['Count'] == 0) {
        $checkDeptMaster = true;
    }
    return $checkDeptMaster;
}

function getlogindetail($FieldName, $WhereFieldName, $WhereValue) {
    $getlogindetail = "";
    $sql = "SELECT " . $FieldName . " FROM mpc_login_master where " . $WhereFieldName . " = '" . $WhereValue . "'";
    $result = mysql_query($sql) or die("Error in : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());
    if (mysql_num_rows($result) > 0) {
        $row = mysql_fetch_array($result);
        $getlogindetail = $row[$FieldName];
    }
    return $getlogindetail;
}

function getdepartmentDetail($field_name, $emp_id, $date) {
    $getdepartmentDetail = "";
    $sql_to = "SELECT " . $field_name . " FROM mpc_department_employee where emp_id = '$emp_id' and from_date<='$date' and '$date'<=to_date and to_date!='0000-00-00'";
//echo $sql;
    $result_to = mysql_query($sql_to) or die("Error in : " . $sql_to . "<br>" . mysql_errno() . " : " . mysql_error());

    if (mysql_num_rows($result_to) > 0) {
        while ($row = mysql_fetch_array($result_to)) {
            $getdepartmentDetail = $row[$field_name];
        }
    }

    $sql_to = "SELECT " . $field_name . " FROM mpc_department_employee where emp_id = '$emp_id' and from_date<='$date' and to_date='0000-00-00'";
//echo $sql;
    $result_to = mysql_query($sql_to) or die("Error in : " . $sql_to . "<br>" . mysql_errno() . " : " . mysql_error());

    if (mysql_num_rows($result_to) > 0) {
        while ($row = mysql_fetch_array($result_to)) {
            $month = substr($date, 5, 2);
            $getdepartmentDetail = $row[$field_name];
        }
    }
    return $getdepartmentDetail;
}

function getdesignationDetail($field_name, $emp_id, $date) {
    $getdesignationDetail = "";

    $sql_to = "SELECT " . $field_name . " FROM mpc_designation_employee where emp_id = '$emp_id' and from_date<='$date' and '$date'<=to_date and to_date!='0000-00-00'";
//echo $sql;
    $result_to = mysql_query($sql_to) or die("Error in : " . $sql_to . "<br>" . mysql_errno() . " : " . mysql_error());

    if (mysql_num_rows($result_to) > 0) {
        while ($row = mysql_fetch_array($result_to)) {
            $getdesignationDetail = $row[$field_name];
        }
    }

    $sql_to = "SELECT " . $field_name . " FROM mpc_designation_employee where emp_id = '$emp_id' and from_date<='$date' and to_date='0000-00-00'";
//echo $sql;
    $result_to = mysql_query($sql_to) or die("Error in : " . $sql_to . "<br>" . mysql_errno() . " : " . mysql_error());

    if (mysql_num_rows($result_to) > 0) {
        while ($row = mysql_fetch_array($result_to)) {
            $month = substr($date, 5, 2);
            $getdesignationDetail = $row[$field_name];
        }
    }
    return $getdesignationDetail;
}

function getdesignationMaster($FieldName, $WhereFieldName, $WhereValue) {
    $getdesignationMaster = "";
    $sql = "SELECT " . $FieldName . " FROM mpc_designation_master where " . $WhereFieldName . " = '" . $WhereValue . "'";
    $result = mysql_query($sql) or die("Error in : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());
    if (mysql_num_rows($result) > 0) {
        $row = mysql_fetch_array($result);
        $getdesignationMaster = $row[$FieldName];
    }
    return $getdesignationMaster;
}

function getadvance($emp_id, $month, $year) {
    $getadvance = 0;
    $sql = "SELECT sum(deduction) as net_deduction  FROM mpc_advance_employee where emp_id = '" . $emp_id . "' and  MONTH(deduction_date)='" . $month . "' and YEAR(deduction_date) ='" . $year . "'and deduction_by='Salary' ";
    $result = mysql_query($sql) or die("Error in : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());
    if (mysql_num_rows($result) > 0) {
        $row = mysql_fetch_array($result);
        $getadvance = $row['net_deduction'];
    }
    return $getadvance;
}

function getloan($emp_id) {
    $getloan = "";
    $sql = "SELECT installments_decided FROM mpc_loan_employee where emp_id = '" . $emp_id . "' and status ='Open'";
    $result = mysql_query($sql) or die("Error in : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $getloan = $getloan + $row['installments_decided'];
        }
    }
    return $getloan;
}

function getLastLeaveByEmpID($emp_id) {

    $getLastLeaveByEmpID = '';
    $sql = "SELECT date FROM mpc_attendence_master where emp_id = $emp_id and attendance_status ='PL' or attendance_status ='CL'order by date limit 0,1";
//echo $sql;
    $result = mysql_query($sql) or die("Error in : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());

    if (mysql_num_rows($result) > 0) {

        while ($row = mysql_fetch_array($result)) {
            $getLastLeaveByEmpID = $row['date'];
        }
    }

    return $getLastLeaveByEmpID;
}

function checkEmpTable($emp_id, $table_name) {

    $checkEmpTable = '';
    $sql = "SELECT count(*) as count FROM " . $table_name . " where emp_id = '$emp_id'";
//echo $sql;
    $result = mysql_query($sql) or die("Error in : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());

    if (mysql_num_rows($result) > 0) {

        while ($row = mysql_fetch_array($result)) {
            $checkEmpTable = $row['count'];
        }
    }

    return $checkEmpTable;
}

function getemployeeDetailByTicket($field_name, $ticket_id) {
    $getemployeeDetailByTicket = "";
    $sql = "SELECT " . $field_name . " FROM mpc_employee_master where ticket_no = '$ticket_id'";
//echo $sql;
    $result = mysql_query($sql) or die("Error in : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());

    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $getemployeeDetailByTicket.= $row[$field_name];
        }
    }
    return $getemployeeDetailByTicket;
}

function dateDifference($date1, $date2) {
    $d1 = (is_string($date1) ? strtotime($date1) : $date1);
    $d2 = (is_string($date2) ? strtotime($date2) : $date2);

    $diff_secs = abs($d1 - $d2);
    $base_year = min(date("Y", $d1), date("Y", $d2));

    $diff = mktime(0, 0, $diff_secs, 1, 1, $base_year);

    return array
        (
        "years" => abs(substr(date('Ymd', $d1) - date('Ymd', $d2), 0, -4)),
        "months_total" => (date("Y", $diff) - $base_year) * 12 + date("n", $diff) - 1,
        "months" => date("n", $diff) - 1,
        "days_total" => floor($diff_secs / (3600 * 24)),
        "days" => date("j", $diff) - 1,
        "hours_total" => floor($diff_secs / 3600),
        "hours" => date("G", $diff),
        "minutes_total" => floor($diff_secs / 60),
        "minutes" => (int) date("i", $diff),
        "seconds_total" => $diff_secs,
        "seconds" => (int) date("s", $diff)
    );
}

function getweeklyoffDetail($field_name, $emp_id, $date) {
    $getweeklyoffDetail = "";
    /* $sql_to = "SELECT ".$field_name." FROM mpc_weekly_off_employee where emp_id = '$emp_id' and from_date<='$date' and '$date'<=to_date and to_date!='0000-00-00'";
      //echo $sql;
      $result_to = mysql_query ($sql_to) or die ("Error in : ".$sql_to."<br>".mysql_errno()." : ".mysql_error());

      if(mysql_num_rows($result_to)>0)
      {
      while($row = mysql_fetch_array($result_to))
      {
      $getweeklyoffDetail =  $row[$field_name];
      }
      } */

    $sql_to = "SELECT " . $field_name . " FROM mpc_weekly_off_employee where emp_id = '$emp_id' and from_date<='$date' and to_date='0000-00-00'";
//echo $sql_to."<br><br>";
    $result_to = mysql_query($sql_to) or die("Error in : " . $sql_to . "<br>" . mysql_errno() . " : " . mysql_error());

    if (mysql_num_rows($result_to) > 0) {
        while ($row = mysql_fetch_array($result_to)) {
            $month = substr($date, 5, 2);
            $getweeklyoffDetail = $row[$field_name];
        }
    }
    return $getweeklyoffDetail;
}

function getloanPaid($loan_id) {
    $getloanPaid = "";
    $sql = "SELECT sum(installments) as loanPaid FROM mpc_loan_installments where loan_id = '" . $loan_id . "'";
    $result = mysql_query($sql) or die("Error in : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $getloanPaid = $row['loanPaid'];
        }
    }
    return $getloanPaid;
}

function getloanDeduction($emp_id, $month, $year) {
    $getloanDeduction = "";
    $sql = "SELECT sum(installments) as loanPaid FROM mpc_loan_installments,mpc_loan_employee where mpc_loan_employee.rec_id=mpc_loan_installments.loan_id and mpc_loan_employee.emp_id  = '" . $emp_id . "' and  MONTH(installment_date )='" . $month . "' and YEAR(installment_date) ='" . $year . "' and installment_by='Salary'";
    $result = mysql_query($sql) or die("Error in : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $getloanDeduction = $row['loanPaid'];
        }
    }
    return $getloanDeduction;
}

function getSalaryDeduction($emp_id, $month, $year) {
    $getSalaryDeduction = "";
    $sql = "SELECT (sum(salary_fine)+sum(salary_damage)+sum(salary_canteen )+sum(salary_society_welfare)+sum(salary_electrical)+sum(salarly_security)+sum(salary_house_rent) )as salarydeduction FROM mpc_salary_deduction where emp_id  = '" . $emp_id . "' and  MONTH(salary_deduction_date)='" . $month . "' and YEAR(salary_deduction_date) ='" . $year . "'";
    $result = mysql_query($sql) or die("Error in : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $getSalaryDeduction = $row['salarydeduction'];
        }
    }
    return $getSalaryDeduction;
}

function validate_weekoff_before($emp_id, $mm, $dd, $yy) {
    $date_before = date('Y-m-d', mktime(0, 0, 0, $mm, $dd - 1, $yy));
    $status = getLeavestatusBydate($emp_id, $date_before);
    if ($status == "H") {
        validate_weekoff_before($emp_id, $$mm, $dd, $yy);
    } else if ($status == "P" or $status == "OD") {
        return true;
    } else {
        return false;
    }
}

function validate_weekoff_after($emp_id, $mm, $dd, $yy) {
    $date_after = date('Y-m-d', mktime(0, 0, 0, $mm, $dd + 1, $yy));
    $status = getHoliday($emp_id, $date_after);
    if ($status == "H") {
        validate_weekoff_after($emp_id, $$mm, $dd, $yy);
    } else if (getLeavestatusBydate($emp_id, $date_after) == "P" or getLeavestatusBydate($emp_id, $date_after) == "OD") {
        return true;
    } else {
        return false;
    }
}

?>