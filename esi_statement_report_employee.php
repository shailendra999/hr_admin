<?
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
if (isset($_POST["employee_type"]) and isset($_POST["ticket_id"]) and isset($_POST["department"]) and isset($_POST["sub_department"])
        and isset($_POST["plant_name"])) {
    if (($_POST["employee_type"] != "")) {
        $select_string = ",mpc_designation_employee.*,mpc_designation_master.*";
        $employee_type = $_POST["employee_type"];
        $table_list = ",mpc_designation_employee,mpc_designation_master";
        $where_string.=" and mpc_designation_employee.emp_id =mpc_employee_master.rec_id and mpc_designation_employee.designation_id=mpc_designation_master.rec_id and mpc_designation_master.emp_category='$employee_type' and mpc_designation_employee.to_date='0000-00-00'";
    }
    if ($_POST["ticket_id"] != "") {
        $select_string = "";
        $ticket_id = $_POST["ticket_id"];
        $table_list.= "";
        $where_string.=" and mpc_employee_master.ticket_no ='$ticket_id'";
    }
    if ($_POST["department"] != "" and $_POST["sub_department"] == "") {
        $select_string = ",mpc_department_employee.*,mpc_department_master.*";
        $department = $_POST["department"];
        $table_list.= ",mpc_department_employee,mpc_department_master";

        $where_string.=" and mpc_department_employee.emp_id =mpc_employee_master.rec_id and 
 mpc_department_master.reference_id ='$department' and mpc_department_employee.to_date='0000-00-00' and
    mpc_department_master.rec_id=mpc_department_employee.dept_id";
    }
    if ($_POST["sub_department"] != "") {
        $select_string = ",mpc_department_employee.*";
        $department = $_POST["department"];
        $sub_department = $_POST["sub_department"];
        $table_list.= ",mpc_department_employee";

        $where_string.=" and mpc_department_employee.emp_id =mpc_employee_master.rec_id and
 mpc_department_employee.dept_id ='$sub_department' and mpc_department_employee.to_date='0000-00-00'";
    }
    if ($_POST["plant_name"] != "") {
        $select_string = ",mpc_plant_employee.*";
        $plant_name = $_POST["plant_name"];
        $table_list.= ",mpc_plant_employee";
        $where_string.=" and mpc_plant_employee.emp_id =mpc_employee_master.rec_id and mpc_plant_employee.plant_id ='$plant_name' and mpc_plant_employee.to_date='0000-00-00'";
    }
}
if (isset($_POST["btn_submit_x"]) or isset($_GET['month'])) {
    $sql_prj = "select DAY(mpc_official_detail.date_joining) as 'Day',
            MONTH(mpc_official_detail.date_joining) as 'Month' ,
            YEAR(mpc_official_detail.date_joining) as 'Year',
            mpc_official_detail.date_joining,
            mpc_employee_master.rec_id as id,
            mpc_employee_master.ticket_no,
            mpc_employee_master.first_name,
            mpc_employee_master.last_name,
            mpc_official_detail.emp_id,mpc_account_detail.emp_id,
            mpc_account_detail.date_releaving,
            mpc_official_detail.employee_typ  $select_string from " . $mysql_table_prefix . "employee_master,
            mpc_official_detail ,
            mpc_account_detail $table_list where 
            mpc_employee_master.rec_id!='' and 
            mpc_employee_master.rec_id=mpc_official_detail.emp_id and 
            EXTRACT(YEAR_MONTH FROM mpc_official_detail.date_joining)<='$year$month' 
            and mpc_employee_master.rec_id=mpc_account_detail.emp_id and 
            mpc_account_detail.date_releaving ='0000-00-00' 
            $where_string order by mpc_employee_master.ticket_no ASC";

    $result_prj = mysql_query($sql_prj) or die("Error in Query :" . $sql_prj . "<br>" . mysql_error() . ":" . mysql_errno());
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
                    <td align="center" class="gray_bg">&nbsp; <a href="#" style="text-decoration:none;color:gray;">Report-> </a>ESI statement report</td>
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
                                                                                </tr>
                                                                                <tr>
                                                                                    <td align="left" class="text_1"><b>Month</b></td>
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
                                                                    <tr> 
                                                                        <td class="text_1" colspan="2">
                                                                            <b>Filter By:</b>
                                                                        </td>
                                                                    <tr>
                                                                        <td class="text_1">
                                                                            <b>Emp Type</b>
                                                                        </td>
                                                                        <td>
                                                                            <select name="employee_type" id="employee_type">


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
                                                                        <td>
                                                                            <input type="text" name="ticket_id" id="ticket_id" value="<?= $ticket_id ?>" size="4"/>
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
                                                                            <b>Plant</b>
                                                                        </td>
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
                                                                    </tr> 
                                                                    <tr>
                                                                        <td colspan="6" align="center" style="padding-top:5px;">
                                                                            <input name="no_refresh" type="hidden" id="no_refresh" value="<?php echo uniqid(rand()); ?>" />
                                                                            <input type="image" src="images/btn_view.jpg" name="btn_submit" id="btn_submit" value="View"/>

                                                                            <a href="javascript:;" onclick="document.location = 'esi_statement_report_employee.php';">
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
                                                        if (mysql_num_rows($result_prj) > 0) {
                                                            $sno = $start + 1;
                                                            ?>
                                                            <tr>
                                                                <td align="right">
                                                                    <table cellpadding="0" cellspacing="0" border="0">
                                                                        <tr>
                                                                            <td>
                                                                                <form action="print_esi_statement_report_employee.php" method="post" name="frm_print" id="frm_print" target="_blank">
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
                                                                            <td align="right">
                                                                                <form action="excel_esi_report.php" method="post" name="frm_print_xls" id="frm_print_xls" target="_blank" style="display:inline;">
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
                                                                                <td width="5%" align="center"><b>IsDisable</b></td>
                                                                                <td width="5%" align="center"><b>IPNo.</b></td>
                                                                                <td width="15%" align="center"><b>IPName<br/></b></td>
                                                                                <td align="center"><b>No.Days</b></td>
                                                                                <td align="center"><b>TotalWages</b></td>
                                                                                <td align="center"><b>IPContribution</b></td>
                                                                                <td align="center"><b>Reason</b></td>
                                                                            </tr>
                                                                            <?
                                                                            while ($row = mysql_fetch_array($result_prj)) {
                                                                                $basic_site = 0;
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
                                                                                $emp_id = $row['id'];
                                                                                $Total = 0;
                                                                                $flag = 0;

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

                                                                                    $date1 = $yy . "-" . $mm . "-" . $dd;
                                                                                    $weekday = date("l", mktime(0, 0, 0, $mm, $dd, $yy));

                                                                                    /* ______________________________________ */
                                                                                    $sql_to_wf = "SELECT off_day FROM mpc_shift_detail where emp_id = '$row[id]'";
                                                                                    $result_to_wf = mysql_query($sql_to_wf) or die("Error in : " . $sql_to_wf . "<br>" . mysql_errno() . " : " . mysql_error());
                                                                                    $row_wf = mysql_fetch_array($result_to_wf);
                                                                                    $woff_day = $row_wf['off_day'];
                                                                                    /* ______________________________________ */
//                                                                                    echo $leave_status;
                                                                                    if ($woff_day == $weekday and $row['employee_typ'] != 'daily_wages') {
                                                                                        $date_before = date('Y-m-d', mktime(0, 0, 0, $mm, $dd - 1, $yy));
                                                                                        $date_after = date('Y-m-d', mktime(0, 0, 0, $mm, $dd + 1, $yy));
                                                                                        $before_date = getLeavestatusBydate($row['id'], $date_before);
                                                                                        $after_date = getLeavestatusBydate($row['id'], $date_after);
                                                                                        if ($before_date == 'P' or $before_date == 'OD' or $after_date == 'P' or $after_date == 'OD') {
                                                                                            if ($row['employee_typ'] != 'daily_wages') {
                                                                                                $Total++;
                                                                                                $flag = 1;
                                                                                            }
                                                                                        } else if (getHoliday('rec_id', $date_before) != "") {
                                                                                            if (validate_weekoff_before($row['id'], $mm, $dd - 1, $yy)) {
                                                                                                $Total++;
                                                                                                $flag = 1;
                                                                                            } else {
                                                                                                $flag = 1;
                                                                                                $wo++;
                                                                                                $Total++;
                                                                                                $leave_status = 'w';
                                                                                            }
                                                                                        } else if (getHoliday('rec_id', $date_after) != "") {
                                                                                            if (validate_weekoff_after($row['id'], $mm, $dd + 1, $yy)) {
                                                                                                $Total++;
                                                                                                $flag = 1;
                                                                                            }
                                                                                        } else if ($leave_status == "Pl") {
                                                                                            $Total++;
                                                                                            $flag = 1;
                                                                                        } else if ($leave_status == "Cl") {
                                                                                            $Total++;
                                                                                            $flag = 1;
                                                                                        } elseif ($leave_status == "HCL") {
                                                                                            $Total++;
                                                                                            $flag = 1;
                                                                                        }
                                                                                    } else if (getHoliday('rec_id', $date1) != "") {
                                                                                        $date_before = date('Y-m-d', mktime(0, 0, 0, $mm, $dd - 1, $yy));
                                                                                        $date_after = date('Y-m-d', mktime(0, 0, 0, $mm, $dd + 1, $yy));
                                                                                        $before_date = getLeavestatusBydate($row['id'], $date_before);
                                                                                        $after_date = getLeavestatusBydate($row['id'], $date_after);
                                                                                        $weekday_before = date("l", mktime(0, 0, 0, $mm, $dd - 1, $yy));
                                                                                        $weekday_after = date("l", mktime(0, 0, 0, $mm, $dd + 1, $yy));


                                                                                        if ($before_date == 'Cl') {
                                                                                            $i_before = 1;
                                                                                            do {
                                                                                                $date_before = date('Y-m-d', mktime(0, 0, 0, $mm, $dd - $i_before, $yy));

                                                                                                $before_date = getLeavestatusBydate($row['id'], $date_before);
                                                                                                $i_before++;
                                                                                            } while ($before_date == 'Cl');
                                                                                        }

                                                                                        if ($before_date == 'P' or $before_date == 'OD' or $after_date == 'P' or $after_date == 'OD') {
                                                                                            $h++;
                                                                                            $leave_status = 'H';
                                                                                            $Total++;
                                                                                            $flag = 1;
                                                                                        } else if (getweeklyoffDetail('off_day', $row['id'], $date_before) == $weekday_before) {
                                                                                            if (validate_weekoff_before($row['id'], $mm, $dd - 1, $yy)) {
                                                                                                $h++;
                                                                                                $leave_status = 'H';
                                                                                                $Total++;
                                                                                                $flag = 1;
                                                                                            }
                                                                                        } else if (getweeklyoffDetail('off_day', $row['id'], $date_after) == $weekday_after) {
                                                                                            if (validate_weekoff_after($row['id'], $mm, $dd + 1, $yy)) {
                                                                                                $h++;
                                                                                                $leave_status = 'H';
                                                                                                $Total++;
                                                                                                $flag = 1;
                                                                                            }
                                                                                        } else {
                                                                                            $leave_status = getLeavestatusBydate($row['id'], $date1);
                                                                                            if ($leave_status == "" or $leave_status == "A") {
                                                                                                $leave_status = 'A';
                                                                                                $absent++;
                                                                                            } else if ($leave_status == "Pl") {
                                                                                                $Pl++;
                                                                                                $Total++;
                                                                                                $flag = 1;
                                                                                            } else if ($leave_status == "Cl") {
                                                                                                $Cl++;
                                                                                                $Total++;
                                                                                                $flag = 1;
                                                                                            } elseif ($leave_status == "HCL") {

                                                                                                $Total++;
                                                                                                $flag = 1;
                                                                                            }
                                                                                        }
                                                                                    } else {
                                                                                        $leave_status = getLeavestatusBydate($row['id'], $date1);
                                                                                        if ($leave_status == "P" or $leave_status == "C/OFF" or $leave_status == "OD" or $leave_status == "Cl" or $leave_status == "Pl" or $leave_status == "HCL") {
                                                                                            $Total++;
                                                                                            $flag = 1;
                                                                                        } else if ($leave_status == "HD") {
                                                                                            $Total = $Total + 1;
                                                                                            $flag = 2;
                                                                                        } elseif ($leave_status == "HCL") {
                                                                                            $Total = $Total + 1;
                                                                                            $flag = 2;
                                                                                        } elseif ($leave_status == "P/2") {
                                                                                            $Total = $Total + 0.5;
                                                                                            $flag = 2;
                                                                                        }
                                                                                    }
                                                                                    if ($flag == 1) {
                                                                                        if ($row['employee_typ'] == 'daily_wages') {

                                                                                            $total_salary_basic = $total_salary_basic + (getSalaryDetail("basic", $emp_id, $date1));
                                                                                            $total_lta = $total_lta + (getSalaryDetail("leave_travel_allow", $emp_id, $date1));
                                                                                            $total_convence = $total_convence + (getSalaryDetail("convence", $emp_id, $date1));
                                                                                            $total_medical = $total_medical + (getSalaryDetail("medical", $emp_id, $date1));

                                                                                            $total_hra = $total_hra + (getSalaryDetail("hra", $emp_id, $date1));

                                                                                            $side_allowance = $side_allowance + (getSalaryDetail("side_allowance", $emp_id, $date1));
                                                                                            $other_deductions = $other_deductions + (getSalaryDetail("other_deductions", $emp_id, $date1));
                                                                                        } else {
                                                                                            $total_salary_basic = $total_salary_basic + (getSalaryDetail("basic", $emp_id, $date1) / $day2);
                                                                                            $total_lta = $total_lta + (getSalaryDetail("leave_travel_allow", $emp_id, $date1) / $day2);
                                                                                            $total_convence = $total_convence + (getSalaryDetail("convence", $emp_id, $date1) / $day2);
                                                                                            $total_medical = $total_medical + (getSalaryDetail("medical", $emp_id, $date1) / $day2);

                                                                                            $total_hra = $total_hra + (getSalaryDetail("hra", $emp_id, $date1) / $day2);

                                                                                            $side_allowance = $side_allowance + (getSalaryDetail("side_allowance", $emp_id, $date1) / $day2);
                                                                                            $other_deductions = $other_deductions + (getSalaryDetail("other_deductions", $emp_id, $date1) / $day2);
                                                                                        }
                                                                                    }
                                                                                    if ($flag == 2) {
                                                                                        if ($row['employee_typ'] == 'daily_wages') {
                                                                                            $total_salary_basic = $total_salary_basic + ((getSalaryDetail("basic", $emp_id, $date1)) / 2);
                                                                                            $total_lta = $total_lta + ((getSalaryDetail("leave_travel_allow", $emp_id, $date1)) / 2);
                                                                                            $total_convence = $total_convence + ((getSalaryDetail("convence", $emp_id, $date1)) / 2);
                                                                                            $total_medical = $total_medical + ((getSalaryDetail("medical", $emp_id, $date1)) / 2);

                                                                                            $total_hra = $total_hra + ((getSalaryDetail("hra", $emp_id, $date1)) / 2);

                                                                                            $side_allowance = $side_allowance + ((getSalaryDetail("side_allowance", $emp_id, $date1)) / 2);
                                                                                            $other_deductions = $other_deductions + ((getSalaryDetail("other_deductions", $emp_id, $date1)) / 2);
                                                                                        } else {
                                                                                            $total_salary_basic = $total_salary_basic + ((getSalaryDetail("basic", $emp_id, $date1) / $day2) / 2);
                                                                                            $total_lta = $total_lta + ((getSalaryDetail("leave_travel_allow", $emp_id, $date1) / $day2) / 2);
                                                                                            $total_convence = $total_convence + ((getSalaryDetail("convence", $emp_id, $date1) / $day2) / 2);
                                                                                            $total_medical = $total_medical + ((getSalaryDetail("medical", $emp_id, $date1) / $day2) / 2);

                                                                                            $total_hra = $total_hra + ((getSalaryDetail("hra", $emp_id, $date1) / $day2) / 2);

                                                                                            $side_allowance = $side_allowance + ((getSalaryDetail("side_allowance", $emp_id, $date1) / $day2) / 2);
                                                                                            $other_deductions = $other_deductions + ((getSalaryDetail("other_deductions", $emp_id, $date1) / $day2) / 2);
                                                                                        }
                                                                                    }
                                                                                    $flag = 0;
                                                                                    $i++;
                                                                                }

                                                                                $basic_rate = getSalaryDetail("basic", $emp_id, $date1);

                                                                                $total_earning = $total_salary_basic + $total_lta + $total_convence + $total_medical + $total_hra + $side_allowance;
                                                                                $esic_rate = getAccountDetail('esic_rate', $emp_id);
                                                                                $total_esi = ($total_earning * $esic_rate) / 100;

                                                                                $total_esi = round("$total_esi");

                                                                                if ($esic_rate > 0) {
                                                                                    ?>
                                                                                    <tr <? if ($sno % 2 == 1) { ?> bgcolor="#F8F8F8" <? } ?> class="tableTxt">
                                                                                        <td width="5%" align="center"><?= $sno ?></td>
                                                                                        <td width="5%" align="center">
                                                                                            -
                                                                                        <td>
                                                                                            <?= getAccountDetail('esic_number', $row['id']) ?>
                                                                                        </td>
                                                                                        <td width="15%" align="left"><?= $row['first_name'] ?> <?= $row['last_name'] ?><br/></td>
                                                                                        <td align="center">
                                                                                            <?= $Total ?>
                                                                                        </td>
                                                                                        <td align="center">
                                                                                            <?= round($total_earning) ?>
                                                                                        </td>
                                                                                        <td align="center"> 
                                                                                            <?= round($total_esi) ?>
                                                                                        </td>
                                                                                        <td align="center">
                                                                                            <?
                                                                                            if ($Total == 0) {
                                                                                                echo "On Leave";
                                                                                            } else {
                                                                                                echo "-";
                                                                                            }
                                                                                            ?>
                                                                                        </td>

                                                                                    </tr>
                                                                                    <?
                                                                                    $sno++;
                                                                                }
                                                                            }
                                                                            ?>														 
                                                                        </table>                                                         
                                                                    </div>  
                                                                </td>
                                                            </tr> 
                                                            <?
                                                        } else {
                                                            ?>
                                                            <tr class="table_rows">
                                                                <td align="center" colspan="8">No records found</td>
                                                            </tr>
                                                            <?
                                                        }
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