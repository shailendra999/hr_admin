<?php
include ("inc/hr_header.php");
$msg = '';
$plant = "";
$dep = "";
$dept_id = "";
if (isset($_GET['start'])) {
    if ($_GET['start'] == 'All') {
        $start = 0;
    } else {
        $start = $_GET['start'];
    }
} else {
    $start = 0;
}
if (isset($_POST['month'])) {
    $month = $_POST['month'];
} else if (isset($_GET['month'])) {
    $month = $_GET['month'];
} else {
    $month = date("m");
}
if (isset($_POST['year'])) {
    $year = $_POST['year'];
} else if (isset($_GET['year'])) {
    $year = $_GET['year'];
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

$date_month = $year . "-" . $month . "-01";
?>
<style>
    select{height:36px !important; width:185px !important;margin:5px 0;}
</style>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
    <tr>
        <td align="left" valign="top" width="230px" style="padding-top:5px;">
            <? include ("inc/snb.php"); ?>
        </td>       
        <td style="padding-left:5px; padding-top:5px;" valign="top">
            <table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
                <tr>
                    <td align="center" class="gray_bg">&nbsp; <a href="#" style="text-decoration:none;color:gray;">Report-> </a>PF statement report</td>
                </tr>
                <tr>
                    <td valign="top">
                        <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td>
                                    <table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
                                        <tr>
                                            <td class="red"><?= $msg ?></td>
                                        </tr>
                                        <tr>
                                            <td align="center" valign="top">
                                                <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-top:5px;" bgcolor="#f3fbd2">
                                                    <tr>
                                                        <td style="padding-top:10px;" align="center">
                                                            <form name="frm_month" id="frm_month" action="" method="post">
                                                                <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
                                                                    <tr>
                                                                        <td colspan="8">
                                                                            <table align="left">
                                                                                <tr>                                                                  
                                                                                    <td align="left" class="text_1"><b>Year</b></td>
                                                                                    <td align="left">
                                                                                        <?
                                                                                        $sql_prd = "select max(date)as MAXDATE,min(date)as MINDATE from " . $mysql_table_prefix . "attendence_master ";
                                                                                        $result_prd = mysql_query($sql_prd) or die("Error in : " . $sql_prd . "<br>" . mysql_errno() . " : " . mysql_error());
                                                                                        $row_prd = mysql_fetch_array($result_prd);
                                                                                        $min_year = 2014;
                                                                                        $max_year = 2015;
                                                                                        ?>    
                                                                                        <select name="year" id="year" style="width:150px; height:25px;" onchange="get_frm('get_month.php', this.value, 'div_month', '');">
                                                                                            <option value="">--select--</option>

                                                                                            <?
                                                                                            for ($i = $min_year; $i <= $max_year; $i++) {
                                                                                                ?>
                                                                                                <option value="<?= $i ?>" <?
                                                                                                if ($i == $year) {
                                                                                                    echo 'selected="selected"';
                                                                                                }
                                                                                                ?>><?= $i ?>
                                                                                                </option>
                                                                                                <?
                                                                                            }
                                                                                            ?>
                                                                                        </select>         						
                                                                                    </td>
                                                                                <tr>                                                                                                             <td align="left" class="text_1"><b>Month</b></td>
                                                                                    <td align="left">
                                                                                        <div id="div_month">
                                                                                            <select id="month" name="month" style="width:150px; height:25px;">
                                                                                                <?
                                                                                                for ($i = 01; $i <= 12; $i++) {
                                                                                                    $j = sprintf("%02d", $i);
                                                                                                    ?>
                                                                                                    <option value="<?= $j ?>" <?
                                                                                                    if ($j == $month) {
                                                                                                        echo 'selected="selected"';
                                                                                                    }
                                                                                                    ?>><?= date("F", mktime(0, 0, 0, $i, 1, 0)) ?></option>
                                                                                                            <?
                                                                                                        }
                                                                                                        ?>

                                                                                            </select>
                                                                                        </div>        						
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                    <!--tr> 
                                                                        <td class="text_1" colspan="2">
                                                                            <b>Filter By:</b>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="text_1">
                                                                            <b>Emp Type</b></td>
                                                                        <td><select name="employee_type" id="employee_type">

                                                                                <option value="">---Select---</option>
                                                                    <?php
                                                                    $que = mysql_query("select type_name from mpc_employee_type_master");

                                                                    while ($row = mysql_fetch_array($que)) {
                                                                        ?>
                                                                                                                                                                                                                                                                            <option value="<?php echo $row['type_name'] ?>" <?php
                                                                        if ($employee_type == $row['type_name']) {
                                                                            echo 'selected="selected"';
                                                                        }
                                                                        ?> ><?php echo $row['type_name']; ?> </option>
                                                                    <?php } ?>
                                                                            </select>

                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="text_1">
                                                                            <b>Emp ID</b></td>
                                                                        <td> <input type="text" name="ticket_id" id="ticket_id" value="<?= $ticket_id ?>" size="4"/>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="text_1">
                                                                            <b>Department</b></td>
                                                                        <td><?
                                                                    $sql = "SELECT * FROM mpc_department_master where reference_id='0' order by department_name";
                                                                    $result = mysql_query($sql) or die("Error in sql : " . $sql . " : " . mysql_errno() . " : " . mysql_error());
                                                                    ?>
                                                                            <select name="department" id="department" style="width:150px; height:25px;" onChange="get_frm('get_department.php', this.value, 'div_sub_dept', 'sub_department');">
                                                                                <option value="">Select</option>
                                                                    <?
                                                                    while ($row = mysql_fetch_array($result)) {
                                                                        ?>
                                                                                                                                                                                                                                                                            <option value="<?= $row['rec_id'] ?>" <? if ($row['rec_id'] == $department) { ?> selected="selected" <? } ?>><?= $row["department_name"] ?></option>
                                                                    <? } ?>
                                                                            </select>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="text_1">
                                                                            <b>Sub Department</b></td>
                                                                        <td>
                                                                            <div id="div_sub_dept">

                                                                                <select name="sub_department" id="sub_department" style="width:150px; height:25px;" onchange="">
                                                                                    <option value="">Select</option>

                                                                                </select>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="text_1">
                                                                            <b>Plant</b></td>
                                                                        <td>
                                                                    <?
                                                                    $sql = "SELECT * FROM mpc_plant_master order by plant_name";
                                                                    $result = mysql_query($sql) or die("Error in sql : " . $sql . " : " . mysql_errno() . " : " . mysql_error());
                                                                    ?>
                                                                            <select name="plant_name" id="plant_name" style="width:150px; height:25px;">
                                                                                <option value="">Select</option>
                                                                    <?
                                                                    while ($row = mysql_fetch_array($result)) {
                                                                        ?>
                                                                                                                                                                                                                                                                            <option value="<?= $row['rec_id'] ?>" <? if ($row['rec_id'] == $plant_name) { ?> selected="selected" <? } ?>><?= $row["plant_name"] ?></option>
                                                                    <? } ?>
                                                                            </select>
                                                                        </td>
                                                                    </tr--> 
                                                                    <tr>
                                                                        <td colspan="6" align="center" style="padding-top:5px;">
                                                                            <input name="no_refresh" type="hidden" id="no_refresh" value="<?php echo uniqid(rand()); ?>" />
                                                                            <input type="image" src="images/btn_view.jpg" name="btn_submit" id="btn_submit" value="View"/>

                                                                            <a href="javascript:;" onclick="document.location = 'pf_statement_report_employee.php';">
                                                                                <img src="images/submit_button_Mahima.jpg" name="over" border="0"></a>
                                                                        </td>
                                                                    </tr>     
                                                                </table>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center" valign="top" style="padding-top:5px;">
                                                <table align="center" width="100%" cellpadding="1" cellspacing="1" border="0" style="border:1px solid #E4E4E4;">
                                                    <?
                                                    if (isset($_POST["btn_submit_x"]) or isset($_GET['month'])) {
//                                                        if (mysql_num_rows($result_prj) > 0) {
                                                        $sno = $start + 1;
                                                        ?>
                                                        <tr>
                                                            <td align="right">
                                                                <table cellpadding="0" cellspacing="0" border="0">
                                                                    <tr>
                                                                        <td>
                                                                            <form action="print_pf_statement_report_employee.php" method="post" name="frm_print" id="frm_print" target="_blank">
                                                                                <input type="hidden" name="print_month" id="print_month" value="<?= $month ?>"/>
                                                                                <input type="hidden" name="print_year" id="print_year" value="<?= $year ?>"/>
                                                                                <input type="hidden" name="print_employee_type" id="print_employee_type" value="<?= $employee_type ?>"/>
                                                                                <input type="hidden" name="print_ticket_id" id="print_ticket_id" value="<?= $ticket_id ?>"/>
                                                                                <input type="hidden" name="print_department" id="print_department" value="<?= $department ?>"/>
                                                                                <input type="hidden" name="print_sub_department" id="print_sub_department" value="<?= $sub_department ?>"/>
                                                                                <input type="hidden" name="print_plant_name" id="print_plant_name" value="<?= $plant_name ?>"/>
                                                                                <input type="image" src="images/btn_print.jpg" name="btn_submit" id="btn_submit" value="View"/>
                                                                            </form>
                                                                        </td>
                                                                        <td valign="top">
                                                                            <form action="pf_report_excel.php" method="post" name="frm_print_xls" id="frm_print_xls" target="_blank" style="display:inline;">
                                                                                <input type="hidden" name="print_month" id="print_month" value="<?= $month ?>"/>
                                                                                <input type="hidden" name="print_year" id="print_year" value="<?= $year ?>"/>
                                                                                <input type="hidden" name="print_employee_type" id="print_employee_type" value="<?= $employee_type ?>"/>
                                                                                <input type="hidden" name="print_ticket_id" id="print_ticket_id" value="<?= $ticket_id ?>"/>
                                                                                <input type="hidden" name="print_department" id="print_department" value="<?= $department ?>"/>
                                                                                <input type="hidden" name="print_sub_department" id="print_sub_department" value="<?= $sub_department ?>"/>
                                                                                <input type="hidden" name="print_plant_name" id="print_plant_name" value="<?= $plant_name ?>"/>
                                                                            </form>
                                                                            <a href="javascript:;" onclick="frm_print_xls.submit()" class="AddMore" >Export To XLS</a>  
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr> 
                                                        <tr>
                                                            <td align="center">
                                                                <div id="div_attandance_list" style="overflow:scroll;height:500px;width:1000px">
                                                                    <table align="center" width="100%" cellpadding="0" cellspacing="0" class="table1" border="1">
                                                                        <tr class="gredBg">
                                                                            <td width="5%" align="center"><b>S.No.</b></td>
                                                                            <td width="5%" align="center"><b>Emp Id </b></td>
                                                                            <td width="5%" align="center"><b>PF NO.</b></td>
                                                                            <td width="15%" align="center"><b>Employee Name<br/></b></td>
                                                                            <td align="center"><b>Present Days</b></td>
                                                                            <td align="center"><b>Basic Salary</b></td>
                                                                            <td align="center"><b>Employee EPF Share</b></td>
                                                                            <td align="center"><b>Employer EPF Share</b></td>

                                                                            <td align="center"><b>Employer FPF Share</b></td>
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
                                                                                        /*                                                                                         * *********************************** */

                                                                                        $sql_to = mysql_query("SELECT off_day FROM mpc_shift_detail where emp_id = '$row[id]'");
                                                                                        $res = mysql_fetch_array($sql_to);
                                                                                        $weekoffdetails = $res['off_day'];

                                                                                        /*                                                                                         * *********************************** */
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

                                                                                $pf_rate = getAccountDetail('pf_rate', $emp_id);
                                                                                $total_pf = round(($total_salary_basic * getAccountDetail('pf_rate', $emp_id)) / 100);
                                                                                $total_epf_employer = ($total_salary_basic * 3.67) / 100;
                                                                                $total_fpf_employer = ($total_salary_basic * 8.33) / 100;

                                                                                if ($pf_rate > 0) {
                                                                                    ?>
                                                                                    <tr <? if ($sno % 2 == 1) { ?> bgcolor="#F8F8F8" <? } ?> class="tableTxt">
                                                                                        <td width="5%" align="center"><?= $sno ?></td>
                                                                                        <td width="5%" align="center"><?= $row['ticket_no'] ?></td>
                                                                                        <td width="5%" align="center"><?= getAccountDetail('pf_number', $row['id']) ?></td>
                                                                                        <td width="5%" align="center">
                                                                                            <?= ucfirst($row['first_name']) ?> <?= ucfirst($row['last_name']) ?><br/>
                                                                                        </td>
                                                                                        <td align="center"><?= $pre ?></td>
                                                                                        <td align="center"><?= round($total_salary_basic) ?></td>
                                                                                        <td align="center"><?= round($total_pf) ?></td>
                                                                                        <td align="center"><?= round($total_epf_employer) ?></td>
                                                                                        <td align="center"><?= round($total_pf - $total_epf_employer) ?></td>
                                                                                    </tr>
                                                                                    <?
                                                                                    $sno++;
                                                                                    $grand_basic_total = $basic_total + $grand_basic_total;
                                                                                    $grand_pf = $total_pf + $grand_pf;
                                                                                }
                                                                            }
                                                                        }
                                                                        ?>	
                                                                        <tr align="center" valign="middle">
                                                                            <td align="center">Total</td>
                                                                        </tr>
                                                                    </table>
                                                                </div>  
                                                            </td>
                                                        </tr> 
                                                        <?php
                                                    }
                                                    ?>          	
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table> 
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<iframe width=168 height=190 name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="calendar/ipopeng.htm" scrolling="no" frameborder="0" style="border:2px ridge; visibility:visible; z-index:999; position:absolute; left:-500px; top:0px;">
</iframe>   
<? include ("inc/hr_footer.php"); ?>	