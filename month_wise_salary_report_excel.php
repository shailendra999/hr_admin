<?php
include ("inc/dbconnection.php");
include ("inc/function.php");

$msg = '';
$plant = "";
$month = "0";
$year = "0";
if (isset($_GET['start'])) {
    if ($_GET['start'] == 'All') {
        $start = 0;
    } else {
        $start = $_GET['start'];
    }
} else {
    $start = 0;
}
if (isset($_POST['print_month'])) {
    $month = $_POST['print_month'];
}
if (isset($_POST['print_year'])) {
    $year = $_POST['print_year'];
}
$employee_type = "";
$department = "";
$sub_department = "";
$plant_name = "";
$ticket_id = "";
$select_string = "";
$table_list = "";
$where_string = "";
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

    $month_all_days = $dd;

    $i++;
}
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=month_salary_report-" . $month . "-" . $year . ".xls")
?>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
    <tr>      
        <td style="padding-left:5px; padding-top:5px;" valign="top">
            <table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
                <tr>
                <img src="images/web_logo.png"/>
                <td align="center"><h2>Laxyo Solution Soft Pvt. Ltd.</h2>
                    <h4>506, Airen Height, Opp. Orbit Mall, AB. Road, Vijay Nagar, Indore (M.P.)</h4>
                </td>
    </tr>
    <tr>
        <td align="left"><h4>Salary Sheet : <?= date("F", mktime(0, 0, 0, $month, 1, 0)) ?>-<?= $year ?></h4></td>
    </tr>
    <tr>
        <td valign="top">
            <table align="center" width="100%" cellpadding="0" cellspacing="0" class="table1" border="1">
                <tr class="gredBg">
                    <td width="5%" align="center"><b>S.No.</b></td>
                    <td width="5%" align="center"><b>Employee Code</b></td>
                    <td width="5%" align="center"><b>Employee Name<br/></b></td>
                    <td width="15%" align="center"><b>Father Name</b></td>
                    <!--td width="15%" align="center"><b>Designation</b></td-->
                    <td width="15%" align="center"><b>Present Days</b></td>
                    <td align="center"><b>Basic Salary</b></td>
                    <td align="center"><b>HRA</b></td>
                    <td align="center"><b>CONV</b></td>
                    <td align="center"><b>Special Allow.</b></td>
                    <td align="center"><b>Telephone Reimb</b></td>
                    <td align="center"><b>Others</b></td>
                    <td align="center"><b>Site Allw.</b></td>
                    <td align="center"><b>Arrear</b></td>

                    <?php
                    if (isset($_REQUEST['over_time'])) {
                        ?>
                        <td align="center"><b>OT</b></td>
                        <?
                    }
                    ?>
                    <td align="center"><b>Gross Salary</b></td>
                    <td align="center"><b>PF</b></td>
                    <td align="center"><b>ESI</b></td>
                    <td align="center"><b>TDS</b></td>
                    <td align="center"><b>Prfn_Tax</b></td>
                    <td align="center"><b>Advance</b></td>
                    <td align="center"><b>Loan</b></td>
                    <td align="center"><b>Other</b></td>
                    <td align="center"><b>Total Ded.</b></td>
                    <td align="center"><b>Payable Salary</b></td>


                </tr>
                <?
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
                $grand_other_ded = 0;
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
                $grand_payable = 0;
                $query_emp = "Select * From mpc_employee_master,mpc_official_detail,mpc_account_detail Where mpc_employee_master.rec_id!='' and mpc_employee_master.rec_id=mpc_official_detail.emp_id and EXTRACT(YEAR_MONTH FROM mpc_official_detail.date_joining)<='$year$month' and mpc_employee_master.rec_id=mpc_account_detail.emp_id and mpc_account_detail.date_releaving ='0000-00-00'";
                $run_emp = mysql_query($query_emp);
                while ($result_emp_master = mysql_fetch_array($run_emp)) {
                    $pay_count = 0;
                    $pre = 0;
                    $emp_id = $result_emp_master['emp_id'];
                    $emp_token = $result_emp_master ['ticket_no'];
                    $first_name = $result_emp_master['first_name'];
                    $last_name = $result_emp_master['last_name'];
                    $emp_token = $result_emp_master['ticket_no'];
                    $empType = $result_emp_master['empType'];
                    $dob = $result_emp_master['dob'];
                    $des = $result_emp_master['designation'];
                    $dep = $result_emp_master['department'];
                    $sub_dep = $result_emp_master['sub_department'];

                    $sql_prj = "select DAY(mpc_official_detail.date_joining) as 'Day',MONTH(mpc_official_detail.date_joining) as 'Month' ,YEAR(mpc_official_detail.date_joining) as 'Year',mpc_official_detail.date_joining,mpc_official_detail.employee_typ,mpc_employee_master.rec_id as id,mpc_employee_master.ticket_no,mpc_employee_master.first_name,mpc_employee_master.last_name,mpc_official_detail.emp_id,mpc_account_detail.emp_id,mpc_account_detail.date_releaving from mpc_employee_master,mpc_official_detail,mpc_account_detail $table_list where mpc_employee_master.rec_id!='' and mpc_employee_master.rec_id=mpc_official_detail.emp_id and EXTRACT(YEAR_MONTH FROM mpc_official_detail.date_joining)<='$year$month' and mpc_employee_master.rec_id=mpc_account_detail.emp_id and mpc_account_detail.date_releaving ='0000-00-00' and mpc_employee_master.emp_id = $emp_id";
                    $result_prj = mysql_query($sql_prj) or die("Error in Query :" . $sql_prj . "<br>" . mysql_error() . ":" . mysql_errno());
                    while ($row = mysql_fetch_array($result_prj)) {
                        $present = 0;
                        $Pl = 0;
                        $h = 0;
                        $wo = 0;
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
                        $tds = 0;
                        $total_phone = 0;
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
                                /*                                 * *********************************** */

                                $sql_to = mysql_query("SELECT off_day FROM mpc_shift_detail where emp_id = '$row[id]'");
                                $res = mysql_fetch_array($sql_to);
                                $weekoffdetails = $res['off_day'];

                                /*                                 * *********************************** */
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
                        $total_other_allowance = round((getSalaryDetail("other_allowance", $emp_id, $date1) / $day2) * $pay_count);
                        $side_allowance = round((getSalaryDetail("side_allowance", $emp_id, $date1) / $day2) * $pay_count);
                        $other_deductions = round((getSalaryDetail("other_deductions", $emp_id, $date1) / $day2) * $pay_count);
                        $total_earning = round($total_salary_basic) + round($total_lta) + round($total_convence) + round($total_medical) + round($total_hra) + round($side_allowance);
                        $total_pf = round(($total_salary_basic * getAccountDetail('pf_rate', $emp_id)) / 100);
                        $total_esi = round(($total_earning * getAccountDetail('esic_rate', $emp_id)) / 100);
                        $total_advance = getadvance($emp_id, $month, $year);

                        $total_loan = getloanDeduction($emp_id, $month, $year);
                        $prof_tax = getSalaryDetail("professional_tax", $emp_id, $date1);
                        $tds = getSalaryDetail("tds", $emp_id, $date1);
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
                        <tr <? if ($sno % 2 == 1) { ?> bgcolor="#F8F8F8" <? } ?> class="tableTxt">
                            <td width="5%" align="center"><?= $sno ?></td>
                            <td width="5%" align="center"><?= $row['ticket_no'] ?></td>
                            <td width="5%" align="center">
                                <?= ucfirst($row['first_name']) ?> <?= ucfirst($row['last_name']) ?><br/>
                            </td>
                            <td width="15%" align="center">
                                <?= ucfirst(getfamilyDetail('father_name', $emp_id)) ?>
                            </td>
                            <td align="center"><?= $pre ?></td>
                            <td align="center"><?= round($total_salary_basic) ?></td>
                            <td align="center"><?= round($total_hra) ?></td>
                            <td align="center"><?= round($total_convence) ?></td>
                            <td align="center"><?= round($side_allowance) ?></td>
                            <td align="center"><?= round($total_phone) ?></td>
                            <td align="center"><?= round($total_other_allowance) ?></td>
                            <td align="center"><?= round($total_site) ?></td>
                            <td align="center"><?php
                                $tot_arrear = 0;
                                $select_arrear = mysql_query("select *,Month(arrear_pay) as pay from mpc_arrear_master where emp_id = $row[id]");
                                while ($fetch_arrear = mysql_fetch_array($select_arrear)) {
                                    $pay = $fetch_arrear['pay'];
                                    $current_month = $mm;
                                    if ($current_month == $pay) {
                                        $tot_arrear = $fetch_arrear['arrear_amount'] + $tot_arrear;
                                    }
                                }
                                echo $tot_arrear;
                                $grand_arrear = $tot_arrear + $grand_arrear;
                                ?></td>
                            <?php
                            if (isset($_REQUEST['over_time'])) {
                                ?>
                                <td align="center"><?= $tot_ot ?></td>
                                <?
                            }
                            ?>
                            <td align="center">
                                <?= round($tot_sal = $tot_ot + $total_other_allowance + $tot_arrear + $total_salary_basic + $total_hra + $total_convence + $side_allowance + $total_phone + $total_site) ?>
                            </td>
                            <td align="center"><?= round($total_pf) ?></td>
                            <td align="center"><?= round($total_esi) ?></td>
                            <td align="center"><?= $tds ?></td>
                            <td align="center"><?= $total_prftax ?></td>
                            <td align="center"><?= $total_advance ?></td>
                            <td align="center"><?= $total_loan ?></td>
                            <td align="center"><?= $other_deductions ?></td>
                            <td align="center"><?= $total_deductions ?></td>
                            <td align="center"><?= $total_Payable = $tot_sal - $total_deductions ?></td>
                            <td></td>
                        </tr>
                        <?php
                        $sno++;
                        $grand_ot = $tot_ot + $grand_ot;
                        $grand_other_allow = $grand_other_allow + $total_other_allowance;
                        $grand_basic = $basic_rate + $grand_basic;
                        $grand_hra = $basic_hra + $grand_hra;
                        $grand_salary_basic = $grand_salary_basic + $total_salary_basic;
                        $grand_total_hra = $total_hra + $grand_total_hra;
                        $grand_basic_convence = $basic_convence + $grand_basic_convence;
                        $grand_total_convence = $total_convence + $grand_total_convence;
                        $grand_basic_spcl = $basic_spcl + $grand_basic_spcl;
                        $grand_side_allowance = $side_allowance + $grand_side_allowance;
                        $grand_basic_phone = $basic_phone + $grand_basic_phone;
                        $grand_total_phone = $total_phone + $grand_total_phone;
                        $grand_basic_site = $basic_site + $grand_basic_site;
                        $grand_total_site = $total_site + $grand_total_site;
                        $grand_basic_total = $basic_total + $grand_basic_total;
                        $grand_tot_sal = $tot_sal + $grand_tot_sal;
                        $grand_pf = $total_pf + $grand_pf;
                        $grand_esi = $total_esi + $grand_esi;
                        $grand_tds = $tds + $grand_tds;
                        $grand_ptax = $total_prftax + $grand_ptax;
                        $grand_advance = $grand_advance + $total_advance;
                        $grand_loan = $grand_loan + $total_loan;
                        $grand_ded = $total_deductions + $grand_ded;
                        $grand_other_ded = $other_deductions + $grand_other_ded;
                        $grand_payable = $total_Payable + $grand_payable;
                    }
                }
                ?>
                <tr align="center" valign="middle">
                    <td colspan="4" align="center">Total</td>
                    <td><?= $total_pre ?></td>
                    <td><?= round($grand_salary_basic) ?></td>
                    <td><?= round($grand_total_hra) ?></td>
                    <td><?= round($grand_total_convence) ?></td>
                    <td><?= round($grand_side_allowance) ?></td>
                    <td><?= round($grand_total_phone) ?></td>
                    <td><?= $grand_other_allow ?></td>
                    <td><?= round($grand_total_site) ?></td>
                    <td><?= $grand_arrear ?></td>
                    <?php
                    if (isset($_REQUEST['over_time'])) {
                        ?>
                        <td align="center"><?= $grand_ot ?></td>
                        <?php
                    }
                    ?>
                    <td><?= round($grand_tot_sal) ?></td>
                    <td><?= round($grand_pf) ?></td>
                    <td><?= $grand_esi ?></td>
                    <td><?= $grand_tds ?></td>
                    <td><?= $grand_ptax ?></td>
                    <td><?= $grand_advance ?></td>
                    <td><?= $grand_loan ?></td>
                    <td><?= $grand_other_ded ?></td>
                    <td><?= $grand_ded ?></td>
                    <td><?= $grand_payable ?></td>
                </tr>		
            </table>
        </td>
    </tr> 
    <?php
//                }
    ?>            	
</table>                                    
</td>
</tr>
</table>