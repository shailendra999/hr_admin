<?php
$total_al = 0;
$total_de = 0;
$mdays = 0;
$ot_amount = 0;
$tot_ot = 0;
include ("inc/dbconnection.php");
include ("inc/function.php");

$emp_check = $_POST["emp_check"];

$count = count($emp_check);
$month = $_POST["card_month"];
$year = $_POST["card_year"];

/* __________________________________calculate month days_____________________________ */

$start_date = "01";

$day1 = $start_date;
$month1 = $month;
$year1 = $year;
$day1 = $day1 + 1;
$end_date = date("t", strtotime($year . "-" . $month . "-01"));
$day2 = $end_date;
$month2 = $month;
$year2 = $year;

$start_date = "$year1-$month1-$day1";
$end_date = "$year2-$month2-$day2";

$date = mktime(0, 0, 0, $month1, $day1, $year1); //Gets Unix timestamp START DATE
$date1 = mktime(0, 0, 0, $month2, $day2, $year2); //Gets Unix timestamp END DATE
$difference = $date1 - $date; //Calcuates Difference
$daysago = floor($difference / 60 / 60 / 24); //Calculates Days Old

$i = 0;
while ($i <= $daysago + 1) {
    if ($i != 0) {
        $date = $date + 86400;
    } else {
        $date = $date - 86400;
    }
    $today = date('Y-m-d', $date);
    $yy = date('Y', $date);
    $mm = date('m', $date);
    $dd = date('d', $date);

    $mdays = $dd;

    $i++;
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
if (isset($_POST['card_month'])) {
    $month = $_POST['card_month'];
} else if (isset($_GET['card_month'])) {
    $month = $_GET['card_month'];
} else {
    $month = date("m");
}

if (isset($_POST['card_year'])) {
    $year = $_POST['card_year'];
} else if (isset($_GET['card_year'])) {
    $year = $_GET['card_year'];
} else {
    $year = date("Y");
}
$employee_type = "";
$department = "";
$sub_department = "";
$plant_name = "";
$ticket_id = "";
$select_string = "";
$table_list = "";
$where_string = "";
//echo $count;
/* __________________________________//calculate month days//_____________________________ */

for ($g = 0; $g < $count; $g++) {

    $emp_id = $emp_check[$g];

    /*     * ***************************************** */
    $start_date = "01";

    $day1 = $start_date;
    $month1 = $month;
    $year1 = $year;

    $day1 = $day1 + 1;

    $end_date = date("t", strtotime($year . "-" . $month . "-01"));

    $day2 = $end_date;
    $month2 = $month;
    $year2 = $year;


    $start_date = "$year1-$month1-$day1";

    $end_date = "$year2-$month2-$day2";
    $month_name = date('F', strtotime($start_date));
    $date = mktime(0, 0, 0, $month1, $day1, $year1); //Gets Unix timestamp START DATE
    $date1 = mktime(0, 0, 0, $month2, $day2, $year2); //Gets Unix timestamp END DATE
    $difference = $date1 - $date; //Calcuates Difference
    $daysago = floor($difference / 60 / 60 / 24); //Calculates Days Old

    $i = 0;
    while ($i <= $daysago + 1) {
        if ($i != 0) {
            $date = $date + 86400;
        } else {
            $date = $date - 86400;
        }
        $today = date('Y-m-d', $date);

        $yy = date('Y', $date);
        $mm = date('m', $date);
        $dd = date('d', $date);

        $month_all_days = $dd;

        $i++;
    }
    $query_emp = "Select * From mpc_employee_master,mpc_account_detail Where mpc_employee_master.emp_id = '$emp_check[$g]' AND mpc_account_detail.emp_id = mpc_employee_master.emp_id";
    $run_emp = mysql_query($query_emp);
    $result_emp_master = mysql_fetch_array($run_emp);
    $emp_token = $result_emp_master ['ticket_no'];
    $first_name = $result_emp_master['first_name'];
    $last_name = $result_emp_master['last_name'];
    $emp_token = $result_emp_master['ticket_no'];
    $empType = $result_emp_master['empType'];
    $dob = $result_emp_master['dob'];
    $des = $result_emp_master['designation'];
    $date_joining = $result_emp_master['date_joining'];
    $select_des = mysql_query("Select * from mpc_designation_master where rec_id = $des");
    $fetch_des = mysql_fetch_array($select_des);
    $designation_name = $fetch_des['designation_name'];
    $dep = $result_emp_master['department'];
    $sub_dep = $result_emp_master['sub_department'];
    $pf_number = $result_emp_master['pf_number'];
    $account_no = $result_emp_master['account_no'];
    $bank_name = $result_emp_master['bank_name'];
//    $sql_prj = "select DAY(mpc_official_detail.date_joining) as 'Day',MONTH(mpc_official_detail.date_joining) as 'Month' ,YEAR(mpc_official_detail.date_joining) as 'Year',mpc_official_detail.date_joining,mpc_official_detail.employee_typ,mpc_employee_master.rec_id as id,mpc_employee_master.ticket_no,mpc_employee_master.first_name,mpc_employee_master.last_name,mpc_official_detail.emp_id,mpc_account_detail.emp_id,mpc_account_detail.date_releaving $select_string from " . $mysql_table_prefix . "employee_master,mpc_official_detail,mpc_account_detail $table_list where mpc_employee_master.rec_id!='' and mpc_employee_master.rec_id=mpc_official_detail.emp_id and EXTRACT(YEAR_MONTH FROM mpc_official_detail.date_joining)<='$year$month' and mpc_employee_master.rec_id=mpc_account_detail.emp_id and mpc_account_detail.date_releaving ='0000-00-00' $where_string  order by ticket_no ASC";
    $sql_prj = "select DAY(mpc_official_detail.date_joining) as 'Day',MONTH(mpc_official_detail.date_joining) as 'Month' ,YEAR(mpc_official_detail.date_joining) as 'Year',mpc_official_detail.date_joining,mpc_official_detail.employee_typ,mpc_employee_master.rec_id as id,mpc_employee_master.ticket_no,mpc_employee_master.first_name,mpc_employee_master.last_name,mpc_official_detail.emp_id,mpc_account_detail.emp_id,mpc_account_detail.date_releaving from mpc_employee_master,mpc_official_detail,mpc_account_detail $table_list where mpc_employee_master.rec_id!='' and mpc_employee_master.rec_id=mpc_official_detail.emp_id and EXTRACT(YEAR_MONTH FROM mpc_official_detail.date_joining)<='$year$month' and mpc_employee_master.rec_id=mpc_account_detail.emp_id and mpc_account_detail.date_releaving ='0000-00-00' and mpc_employee_master.emp_id = $emp_id";
    $result_prj = mysql_query($sql_prj) or die("Error in Query :" . $sql_prj . "<br>" . mysql_error() . ":" . mysql_errno());
//    echo mysql_num_rows($result_prj);

    $date_month = $year . "-" . $month . "-01";
    $grand_basic = 0;
    $grand_lta = 0;
    $grand_ptax = 0;
    $grand_con = 0;
    $grand_tds = 0;
    $grand_medical = 0;
    $grand_pf = 0;
    $grand_esi = 0;
    $grand_sa = 0;
    $grand_lta = 0;
    $grand_earn = 0;
    $grand_ded = 0;
    $grand_net = 0;
    $grand_hra = 0;
    $grand_lta = 0;
    $grand_advance = 0;
    $grand_fine = 0;
    $grand_loan = 0;
    $grand_damage = 0;
    $grand_canteen = 0;
    $grand_society_fare = 0;
    $grand_security = 0;
    $grand_electrical = 0;
    $grand_days = 0;


    while ($row = mysql_fetch_array($result_prj)) {
        $basic_site = 0;
        $pay_count = 0;
        $basic_total = 0;
        $total_salary_basic = 0;
        $total_lta = 0;
        $total_convence = 0;
        $total_medical = 0;
        $total_hra = 0;
        $other_deductions = 0;
        $side_allowance = 0;
        $prof_tax = 0;
        $present = 0;
        $tds = 0;
        $Cl = 0;
        $Pl = 0;
        $h = 0;
        $wo = 0;
        $total_phone = 0;

        $absent = 0;
        $start_date = "01";

        $day1 = $start_date;
        $month1 = $month;
        $year1 = $year;

        $day1 = $day1 + 1;

        $end_date = date("t", strtotime($year . "-" . $month . "-01"));

        $day2 = $end_date;
        $month2 = $month;
        $year2 = $year;

        $start_date = "$year1-$month1-$day1";

        $end_date = "$year2-$month2-$day2";

        $date = mktime(0, 0, 0, $month1, $day1, $year1); //Gets Unix timestamp START DATE
        $date1 = mktime(0, 0, 0, $month2, $day2, $year2); //Gets Unix timestamp END DATE
        $difference = $date1 - $date; //Calcuates Difference
        $daysago = floor($difference / 60 / 60 / 24); //Calculates Days Old

        $i = 0;
        while ($i <= $daysago + 1) {
            if ($i != 0) {
                $date = $date + 86400;
            } else {
                $date = $date - 86400;
            }$today = date('Y-m-d', $date);
            $yy = date('Y', $date);
            $mm = date('m', $date);
            $dd = date('d', $date);
            $date1 = $yy . "-" . $mm . "-" . $dd;
            $today_date = date('Y-m-d');
            if ($row['Day'] > $dd and $row['Month'] == $mm and $row['Year'] == $yy) {
                $leave_status = 'N/A';
            } else if ($today_date <= $date1) {
                $leave_status = '';
            } else {
                /*                 * *********************************** */

                $sql_to = mysql_query("SELECT off_day FROM mpc_shift_detail where emp_id = '$row[id]'");
                $res = mysql_fetch_array($sql_to);
                $weekoffdetails = $res['off_day'];

                /*                 * *********************************** */
                $weekday = date("l", mktime(0, 0, 0, $mm, $dd, $yy));
                if (getHoliday('rec_id', $date1) != "") {
                    $date_before = date('Y-m-d', mktime(0, 0, 0, $mm, $dd - 1, $yy));
                    $date_after = date('Y-m-d', mktime(0, 0, 0, $mm, $dd + 1, $yy));
                    $before_date = getLeavestatusBydate($row['id'], $date_before);
                    $after_date = getLeavestatusBydate($row['id'], $date_after);
                    $weekday_before = date("l", mktime(0, 0, 0, $mm, $dd - 1, $yy));

                    if ($before_date == 'Cl') {
                        $i_before = 1;
                        do {
                            $date_before = date('Y-m-d', mktime(0, 0, 0, $mm, $dd - $i_before, $yy));
                            $before_date = getLeavestatusBydate($row['id'], $date_before);
                            $i_before++;
                        } while ($before_date == 'Cl');
                    }
                    $weekday_after = date("l", mktime(0, 0, 0, $mm, $dd + 1, $yy));
                    if ($before_date == 'P' or $before_date == 'OD' or $after_date == 'P' or $after_date == 'OD') {
                        $h++;
                        $leave_status = 'H';
                        $Total++;
                    } else if (getweeklyoffDetail('off_day', $row['id'], $date_before) == $weekday_before) {
                        if (validate_weekoff_before($row['id'], $mm, $dd - 1, $yy)) {
                            $h++;
                            $leave_status = 'H';
                            $Total++;
                        }
                    } else if (getweeklyoffDetail('off_day', $row['id'], $date_after) == $weekday_after) {
                        if (validate_weekoff_after($row['id'], $mm, $dd + 1, $yy)) {
                            $h++;
                            $leave_status = 'H';
                            $Total++;
                        }
                    } else {
                        $leave_status = getLeavestatusBydate($row['id'], $date1);
                        if ($leave_status == "") {
                            $leave_status = 'A';
                            $absent++;
                            $Total++;
                        } else if ($leave_status == "Pl") {
                            $Pl++;
                            $Total++;
                        } else if ($leave_status == "Cl") {
                            $Cl++;
                            $Total++;
                        } else if ($leave_status == "HCL") {
                            $Cl = $Cl + 0.5;
                            $Total++;
                        } elseif ($leave_status == "w") {
                            $leave_status;
                            $wo++;
                            $Total++;
                        }
                    }
                }
                if ($weekoffdetails == $weekday) {
                    $date_before = date('Y-m-d', mktime(0, 0, 0, $mm, $dd - 1, $yy));
                    $date_after = date('Y-m-d', mktime(0, 0, 0, $mm, $dd + 1, $yy));
                    $before_date = getLeavestatusBydate($row['id'], $date_before);
                    $after_date = getLeavestatusBydate($row['id'], $date_after);
                    if ($before_date == 'A' || $after_date == 'A') {
                        $leave_status == 'A';
                    }
                    if ($before_date == 'P' or $before_date == 'OD' or $after_date == 'P' or $after_date == 'OD' or $before_date == 'HCL' or $after_date == 'HCL' or $after_date == 'P/2' or $before_date == 'P/2') {
                        $wo++;
                        $leave_status = 'w';
                        if ($row['employee_typ'] != 'daily_wages') {
                            $Total++;
                        }
                    } else if (getLeavestatusBydate($row['id'], $date1) == "" or getLeavestatusBydate($row['id'], $date1) == "A") {
                        if ($before_date == 'Pl' && $after_date == 'Pl') {
                            $leave_status = 'Pl';
                            $Pl++;
                            $Total++;
                        } else if ($before_date == 'A' && $after_date == 'A') {
                            $leave_status = 'A';
                            $absent++;
                            $Total++;
                        } else {
                            $leave_status = 'A';
                            $absent++;
                            $Total++;
                        }
                    } else if (getHoliday('rec_id', $date_before) != "") {

                        if (validate_weekoff_before($row['id'], $mm, $dd - 1, $yy)) {
                            $wo++;
                            $leave_status = 'w';
                            if ($row['employee_typ'] != 'daily_wages') {
                                $Total++;
                            }
                        } else {
                            $wo++;
                            $Total++;
                            $leave_status = 'w';
                        }
                    } else if (getHoliday('rec_id', $date_after) != "") {
                        if (validate_weekoff_after($row['id'], $mm, $dd + 1, $yy)) {
                            $wo++;
                            $leave_status = 'w';
                            if ($row['employee_typ'] != 'daily_wages') {
                                $Total++;
                            }
                        }
                    } else if (getLeavestatusBydate($row['id'], $date1) == "" or getLeavestatusBydate($row['id'], $date1) == "A") {
                        if ($before_date == 'Pl' && $after_date == 'Pl') {
                            $leave_status = 'Pl';
                            $Pl++;
                            $Total++;
                        } else if ($before_date == 'A' && $after_date == 'A') {
                            $leave_status = 'A';
                            $absent++;
                            $Total++;
                        } else {
                            $leave_status = 'A';
                            $absent++;
                            $Total++;
                        }
                    } else if ($leave_status == "Pl") {
                        $Pl++;
                        $Total++;
                    } else if ($leave_status == "Cl") {
                        $Cl++;
                        $pay_count++;
                        $Total++;
                    } else if ($leave_status == "HCL") {
                        $pay_count++;
                        $Cl = $Cl + 0.5;
                        $present = $present + 0.5;
                        $Total++;
                    } elseif ($leave_status == "P/2") {
                        $present = $present + 0.5;
                        $pay_count = $pay_count + 0.5;
                        $Total++;
                    }
                } else {
                    $leave_status = getLeavestatusBydate($row['id'], $date1);
                    if ($leave_status == 'w') {
                        $date_before = date('Y-m-d', mktime(0, 0, 0, $mm, $dd - 1, $yy));
                        $date_after = date('Y-m-d', mktime(0, 0, 0, $mm, $dd + 1, $yy));
                        $before_date = getLeavestatusBydate($row['id'], $date_before);
                        $after_date = getLeavestatusBydate($row['id'], $date_after);
                    }
                    if ($leave_status == "P") {
                        $present++;
                        $pay_count++;
                        $Total++;
                    } else if ($leave_status == "A") {
                        $absent++;
                        $Total++;
                    } else if ($leave_status == "Pl") {
                        $Pl++;
                        $Total++;
                    } else if ($leave_status == "Cl") {
                        $Cl++;
                        $pay_count++;
                        $Total++;
                    } else if ($leave_status == "HCL") {
                        $Cl = $Cl + 0.5;
                        $present = $present + 0.5;
                        $pay_count++;
                        $Total = $Total + 0.5;
                    } elseif ($leave_status == "P/2") {
                        $present = $present + 0.5;
                        $pay_count = $pay_count + 0.5;
                        $Total = $Total + 0.5;
                    } else if ($leave_status == "HD") {
                        $date_before = date('Y-m-d', mktime(0, 0, 0, $mm, $dd - 1, $yy));
                        $date_after = date('Y-m-d', mktime(0, 0, 0, $mm, $dd + 1, $yy));
                        $before_date = getLeavestatusBydate($row['id'], $date_before);
                        $after_date = getLeavestatusBydate($row['id'], $date_after);
                        if ($after_date == 'A' || $before_date == "A") {
                            $leave_status = 'A';
                        }
                        $absent = $absent + 1;
                        $Total = $Total + 1;
                    } else if ($leave_status == "" and $today_date >= $date1) {
                        $leave_status = 'A';
                        $absent++;
                        $Total++;
                    } else if ($leave_status == "C/OFF" or $leave_status == "OD") {
                        $Total++;
                    } else if ($leave_status == "w") {
                        $leave_status;
                        $wo++;
                        $Total++;
                    }
                }
            }
            $i++;
        }
        $pre = $present + $Pl + $h + $wo;
        $pay_count = $pay_count + $Pl + $h + $wo;
        $total_pre = $pre + $total_pre;
        $total_salary_basic = round(((getSalaryDetail("basic", $emp_id, $date1)) / $day2 ) * $pay_count);
        $total_lta = round(((getSalaryDetail("leave_travel_allow", $emp_id, $date1) / $day2) * $pay_count));
        $total_convence = round(((getSalaryDetail("convence", $emp_id, $date1) / $day2) * $pay_count));
        $total_medical = round((getSalaryDetail("medical", $emp_id, $date1) / $day2) * $pay_count);
        $total_site = round((getSalaryDetail("site_allowance", $emp_id, $date1) / $day2) * $pay_count);
        $total_hra = round((getSalaryDetail("hra", $emp_id, $date1) / $day2) * $pay_count);
        $total_phone = round((getSalaryDetail("phone", $emp_id, $date1) / $day2) * $pay_count);
        $total_others = round((getSalaryDetail("other_allowance", $emp_id, $date1) / $day2) * $pay_count);
        $side_allowance = round((getSalaryDetail("side_allowance", $emp_id, $date1) / $day2) * $pay_count);
        $other_deductions = round((getSalaryDetail("other_deductions", $emp_id, $date1) / $day2) * $pay_count);
        $total_earning = round($total_salary_basic) + round($total_lta) + round($total_convence) + round($total_medical) + round($total_hra) + round($side_allowance);
        $total_pf = round(($total_salary_basic * getAccountDetail('pf_rate', $emp_id)) / 100);
        $total_esi = round(($total_earning * getAccountDetail('esic_rate', $emp_id)) / 100);
        $total_advance = getadvance($emp_id, $month, $year);

        $total_loan = getloanDeduction($emp_id, $month, $year);
        $prof_tax = getSalaryDetail("professional_tax", $emp_id, $date1);
//        $tds = getSalaryDetail("tds", $emp_id, $date1);
        $monthDeduction = getSalaryDeduction($emp_id, $month, $year);

        $sql = "SELECT sum(salary_fine) as salary_fine,sum(salary_damage) as salary_damage,sum(salary_canteen) as salary_canteen ,sum(salary_society_welfare) as salary_society_welfare, sum(salary_electrical) as salary_electrical, sum(salarly_security) as salarly_security ,sum(salary_house_rent) as salary_house_rent FROM mpc_salary_deduction where emp_id  = '" . $emp_id . "' and  MONTH(salary_deduction_date)='" . $month . "' and YEAR(salary_deduction_date) ='" . $year . "'";

        $result = mysql_query($sql) or die("Error in : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());
        if (mysql_num_rows($result) > 0) {
            $row_salary_deduction = mysql_fetch_array($result);
        }
        $total_esi = ceil("$total_esi");
        $total_deductions = round($total_pf + $total_esi + $total_advance + $other_deductions + $prof_tax + $tds + $total_loan + $monthDeduction);

        $net_salary = $total_earning - $total_deductions;
        $grand_days = $grand_days + $Total;

        /** Over Time Calculation */
        $select_otp = mysql_query("select * from mpc_ot_policy where status = 1");
        $fetch_otp = mysql_fetch_array($select_otp);
        $otp = $fetch_otp['policy_type'];
        $rec_id_ot = $fetch_otp['rec_id'];
        $tot_ot = 0;
        $check_date = $month;
        $tgw = 0;
        $basic_rate = getSalaryDetail("basic", $emp_id, $date1);
//        echo "select * from mpc_good_work_master where emp_id=$emp_id";
        $select_ot = mysql_query("select * from mpc_good_work_master where emp_id=$emp_id");
        while ($fetch_ot = mysql_fetch_array($select_ot)) {
            $pay_date = date('m', strtotime($fetch_ot['date']));
            if ($pay_date == $check_date) {
                $good_work = str_replace(":", ".", "$fetch_ot[good_work]");
                if ($otp == 1) {
                    if ($rec_id_ot == 1) {
                        $ot_amount = round(($basic_rate / $dd / 8) * $good_work);
                    }
                    if ($rec_id_ot == 2) {
                        $ot_amount = round((($basic_rate / $dd / 8 ) * $good_work) * 2);
                    }
                }
                if ($otp == 2) {
                    if ($rec_id_ot == 3) {
                        $ot_amount = round((($basic_rate / $dd / 8) * $good_work));
                    }
                    if ($rec_id_ot == 4) {
                        $ot_amount = round((($basic_rate / $dd / 8 ) * $good_work) * 2);
                    }
                }
                $tot_ot = $ot_amount + $tot_ot;
                $tgw = $good_work + $tgw;
            }
        }
        /** Over Time Calculation */
        ?>
        <html>
            <head>
                <meta charset="utf-8">
                <title>Salary Slip</title>
                <style>
                    *{
                        font-family:Cambria, "Hoefler Text", "Liberation Serif", Times, "Times New Roman", serif;}
                    .slip-container{
                        border:1px solid #000;
                        width:70%;
                        min-width:500px;
                        height:auto;
                        min-height:400px;
                        margin:0 auto;}
                    .box10{width:10%;}
                    .box20{width:20%;}
                    .box25{width:25%;}
                    .box30{width:30%;}
                    .box40{width:40%;}
                    .box50{width:50%;}
                    .box60{width:60%;}
                    .box70{width:70%;}
                    .box80{width:80%;}
                    .box90{width:90%;}
                    .box100{width:100%;}
                    .box10,.box20,.box25,.box30,.box40,
                    .box50,.box60,.box70,.box80,.box90,.box100{
                        float:left;
                        -moz-box-sizing:border-box;
                        -o-box-sizing:border-box;
                        -ms-box-sizing:border-box;
                        box-sizing:border-box;}
                    .txt-center{
                        text-align:center;}
                    .row{
                        width:100%;
                        height:auto;
                        overflow:hidden;
                        border-bottom:2px solid #1a1a1a;}
                    h1,h2,h3,h4,h5,h6{
                        margin:10px 0;}
                    th,td:not(.colon){
                        min-width:50%;
                        border:0px solid #063;}
                    td.colon{
                        width:50px;
                        border-left:2px solid #000;
                        border-right:2px solid #000;}
                    table.main-table thead th{
                        border-bottom:2px solid #000;
                        margin-bottom:5px;
                        text-align:center;}
                    .main-table th{text-align:right;}
                    .main-table td{text-align:center;}
                    .main-table:first-child{
                        border-right:2px solid #000;}
                    tfoot td, tfoot th {
                        border-top: 2px solid #000 !important;
                        padding: 10px 0;}
                    .emp-detail table th{
                        text-align:left;
                        padding-left:20%;}
                    .slip-footer {
                        box-sizing: border-box;
                        padding: 20px 30px;}
                    .logo{margin:20px 20px;}
                </style>
            </head>

            <body>
                <div class="slip-container cnt">
                    <!--header-->
                    <div class="row">
                        <div class="box30 logo"> <img src="images/web_logo.png"> </div>
                        <div class="box40 txt-center">
                            <h2>Laxyo Solution Soft Pvt. Ltd.</h2>
                            <h4>506, Airen Height, Opp. Orbit Mall, AB. Road, Vijay Nagar, Indore (M.P.)</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="box60 txt-center">
                            <h4>Salary Slip for the month of <?= $month_name . "-" . $year ?></h4>
                        </div>
                        <div class="box40 txt-center">
                            <h4>Grade : E2</h4>
                        </div>
                    </div>
                    <!---->
                    <div class="row">
                        <div class="box50 emp-detail">
                            <table class="box100">
                                <tbody>
                                    <tr>
                                        <th>
                                            Employee Name
                                        </th>
                                        <td>
                                            <?= ucfirst($first_name) . " " . ucfirst($last_name) ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Department
                                        </th>
                                        <td>
                                            <?php
                                            if ($dep != 0 && $sub_dep == 0) {
                                                $select_dep = mysql_query("select department_name from mpc_department_master where rec_id = $dep");
                                                $fetch_dep = mysql_fetch_array($select_dep);
                                                echo ucfirst($department_name = $fetch_dep['department_name']);
                                            }
                                            if ($dep != 0 && $sub_dep != 0) {
                                                $select_dep = mysql_query("select department_name from mpc_department_master where rec_id = $sub_dep");
                                                $fetch_dep = mysql_fetch_array($select_dep);
                                                echo ucfirst($department_name = $fetch_dep['department_name']);
                                            }
                                            ?></td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Designation
                                        </th>
                                        <td>
                                            <?= ucfirst($designation_name) ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Present Days
                                        </th>
                                        <td>
                                            <?= $present ?>
                                            <? //= $pay_count ?>
                                        </td>
                                    </tr>
                                    <?php if ($tgw != 0) { ?>
                                        <tr>
                                            <th>OT Hours</th>
                                            <td>
                                                <?= $tgw ?>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                    <tr>
                                        <th>
                                            Total Days
                                        </th>
                                        <td>
                                            <?= $pay_count + $absent ?>
                                            <? //= $mdays ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Date Of Birth
                                        </th>
                                        <td>
                                            <?= date('d-m-Y', strtotime($dob)) ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="box50 emp-detail">
                            <table class="box100">
                                <tbody>
                                    <tr>
                                        <th>
                                            Site Name
                                        </th>
                                        <td>
                                            Corporate Office
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Employee Code
                                        </th>
                                        <td>
                                            <?= $emp_token ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            PF No.
                                        </th>
                                        <td>
                                            <?= $pf_number ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>
                                            ESIC No.
                                        </th>
                                        <td>
                                            <?php
                                            if (!empty($esic_number)) {
                                                echo $esic_number;
                                            } else {
                                                echo "N/A";
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Date of Joining
                                        </th>
                                        <td>
                                            <?= date('d-m-Y', strtotime($date_joining)) ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Bank A/c No.
                                        </th>
                                        <td>
                                            <?= $account_no . " " . $bank_name ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!---->
                    <div class="row">
                        <div class="box20"><strong>Leave Avail :</strong></div>
                        <?php
                        $select = mysql_query("select * from mpc_leave_master");
                        while ($result = mysql_fetch_array($select)) {
                            $results = mysql_query("SELECT count('attendance_status') as total from mpc_attendence_master where attendance_status = '$result[leave_name]' AND emp_id = $row[id] AND Month(date) = '$_REQUEST[month]'");
                            $data = mysql_fetch_assoc($results);
                            if ($result[leave_name] == "Pl") {
                                ?><div class="box10"><strong><?= $result['leave_name'] ?>:</strong>
                                    <?= $Pl ?>  </div>
                                <?
                            }
                            if ($result[leave_name] == "Cl") {
                                ?><div class="box10"><strong><?= $result['leave_name'] ?>:</strong>
                                    <?= $Cl ?>
                                </div>
                                <?
                            }
                        }
                        ?>                           
                        <div class="box10"><strong>Week Off :</strong> <?= $wo ?></div>
                    </div>
                    <!---->
                    <div class="row">
                        <div class="box50">
                            <table class="box100 main-table">
                                <thead>
                                    <tr>
                                        <th colspan="3">
                                <h3>
                                    Earning</h3>
                                </th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th>
                                            Basic
                                        </th>
                                        <td>
                                            <?= round($total_salary_basic) ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            HRA
                                        </th>
                                        <td><?php
                                            if (!empty($total_hra)) {
                                                echo round($total_hra);
                                            } else {
                                                echo "-";
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr><th>Conveyance</th><td><?= round($total_convence) ?></td></tr>
                                    <tr>
                                        <th>Special Allowance</th>
                                        <td>
                                            <?= round($side_allowance) ?>        
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Telephone Allowance (Conv.)
                                        </th>
                                        <td>
                                            <?= round($total_phone) ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Others
                                        </th>
                                        <td>
                                            <?php
                                            if (!empty($total_others)) {
                                                echo round($total_others);
                                            } else {
                                                echo "-";
                                            }
                                            ?></td></tr>
                                    <tr>
                                        <th>
                                            Site Allowance
                                        </th>
                                        <td><?php
                                            if (!empty($total_site)) {
                                                echo round($total_site);
                                            } else {
                                                echo "-";
                                            }
                                            ?></td>
                                    </tr>
                                    <?php
                                    if ($tgw != 0) {
                                        ?>
                                        <tr>
                                            <th>
                                                Over Time 
                                            </th>
                                            <td>
                                                <?= $tot_ot ?>
                                            </td>
                                        </tr>
                                        <?
                                    }
                                    ?>
                                    <tr>
                                        <th>
                                            Arrear
                                        </th>
                                        <td>
                                            <?php
                                            $arrear_amount = 0;
                                            $select_arrear = mysql_query("select *,Month(arrear_pay) as pay from mpc_arrear_master where emp_id = $row[id]");
                                            while ($fetch_arrear = mysql_fetch_array($select_arrear)) {
                                                $pay = $fetch_arrear['pay'];
                                                $current_month = $mm;
                                                if ($current_month == $pay) {
                                                    $arrear_amount = $fetch_arrear['arrear_amount'] + $arrear_amount;
                                                }
                                                $aarear_month = date('m', strtotime($fetch_arrear['arrear_month']));
                                            }
                                            echo round($arrear_amount);
                                            ?>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>
                                            Total
                                        </th>
                                        <td>
                                            <?= $total_earning = $total_others + round($tot_ot) + round($total_salary_basic) + round($total_hra) + round($total_convence) + round($side_allowance) + round($total_phone) + round($total_site) + round($arrear_amount) ?>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>          
                        </div>
                        <table class="box50 main-table">
                            <thead>
                                <tr>
                                    <th colspan="3">
                            <h3>
                                Deduction
                            </h3>
                            </th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>
                                        P.F.
                                    </th>
                                    <td>
                                        <?php
                                        if (!empty($total_pf)) {
                                            echo round($total_pf);
                                        } else {
                                            echo "-";
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        E.S.I.
                                    </th>
                                    <td>
                                        <?php
                                        if (!empty($total_esi)) {
                                            echo round($total_esi);
                                        } else {
                                            echo "-";
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        TDS
                                    </th>
                                    <td>
                                        <?php
//                                        if (!empty($tds)) {
//                                            echo round($tds);
//                                        } else {
//                                            echo "-";
//                                        }
                                        ?>
                                    <td>
                                </tr>
                                <tr>

                                    <th>
                                        Prfn_Tax
                                    </th>
                                    <td>
                                        <?php
                                        if (!empty($prof_tax)) {
                                            echo round($prof_tax);
                                        } else {
                                            echo "-";
                                        }
                                        ?></td>
                                </tr>
                                <tr>
                                    <th>
                                        Advance
                                    </th>
                                    <td><?php
                                        echo round($total_advance);
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Loan
                                    </th>
                                    <td>
                                        <?= round($total_loan) ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Issued Coupon
                                    </th>
                                    <td>
                                        -
                                    </td>
                                </tr>
                                <tr><th>Others</th><td><?= round($other_deductions) ?></td></tr>
                                <?php
                                if ($tgw != 0) {
                                    ?>
                                    <tr>
                                        <th> </th> <td> </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                            <tfoot>
                                <tr><th>Total</th><td><?= round($total_deductions) ?></td></tr>
                            </tfoot>
                        </table>
                    </div>
                    <!---->
                    <div class="row slip-footer">
                        <div class="box50">
                            <h4>Total Payable Amount : <?= $total_earning + $total_deductions ?> /-</h4>
                        </div>
                        <div class="box50">
                            Authorize Signatory
                        </div>
                    </div>
                </div>
            </body>
            <?php
        }
    }
//    }
    ?>
    <style>
        @media print {
            thead {display: table-header-group;}
        }
    </style>
    <script>
        window.print();
    </script>