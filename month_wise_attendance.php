<?php
include ("inc/hr_header.php");
set_time_limit(0);
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
if (isset($_POST["employee_type"]) and isset($_POST["radio"]) and isset($_POST["department"]) and isset($_POST["sub_department"])
        and isset($_POST["plant_name"])) {
			
    if ($_POST['radio'] == 'ticket_id') {
        if ($_POST["txt_value"] != "") {
            $select_string = "";
            $radio = $_POST['radio'];
            $ticket_id = $_POST["txt_value"];
            $table_list.= "";
            $where_string.="and mpc_employee_master.ticket_no ='$ticket_id' ";
        }
    }
    if ($_POST['radio'] == 'emp_name') {


        if ($_POST["txt_value"] != "") {
            $select_string = "";
            $radio = $_POST['radio'];
            $ticket_id = $_POST["txt_value"];
            $table_list.= "";
            $where_string.="and mpc_employee_master.first_name LIKE '$ticket_id%' ";
        }
    }
}
if (isset($_POST["btn_submit_x"]) or isset($_GET['month'])) {
    $sql_prj = "select DAY(mpc_official_detail.date_joining) as 'Day',MONTH(mpc_official_detail.date_joining) as 'Month' ,YEAR(mpc_official_detail.date_joining) as 'Year',mpc_official_detail.date_joining,mpc_official_detail.employee_typ,mpc_employee_master.rec_id as id,mpc_employee_master.ticket_no,mpc_employee_master.first_name,mpc_employee_master.last_name,mpc_official_detail.emp_id,mpc_account_detail.date_releaving $select_string from " . $mysql_table_prefix . "employee_master,mpc_official_detail,mpc_account_detail $table_list where mpc_employee_master.rec_id!='' and  mpc_employee_master.rec_id=mpc_official_detail.emp_id and EXTRACT(YEAR_MONTH FROM mpc_official_detail.date_joining)<='$year$month' and mpc_employee_master.rec_id=mpc_account_detail.emp_id and mpc_account_detail.date_releaving ='0000-00-00' $where_string order by mpc_employee_master.ticket_no  ASC ";

    $result_prj = mysql_query($sql_prj) or die("Error in Query :" . $sql_prj . "<br>" . mysql_error() . ":" . mysql_errno());
}
?>
<style>
    select,input[type="text"]{height:36px !important; width:185px !important;margin:5px 0;}
</style>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
    <tr>
        <td align="left" valign="top" width="230px" style="padding-top:5px;">
            <? include ("inc/snb.php"); ?>
        </td>       
        <td style="padding-left:5px; padding-top:5px;" valign="top">
            <table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
                <tr>
                    <td align="center" class="gray_bg">&nbsp; <a href="#" style="text-decoration:none;color:gray;">Attendance Master-> </a>Attendance Report</td>
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
                                                <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0" style=" margin-top:5px;" bgcolor="#f3fbd2">
                                                    <tr>
                                                        <td style="padding-top:10px;" align="center">
                                                            <form name="frm_month" id="frm_month" action="" method="post">
                                                                <table align="left" width="100%" cellpadding="0" cellspacing="0" border="0">
                                                                    <tr>
                                                                        <td colspan="8">
                                                                            <table align="left">
                                                                                <tr>                                                                  
                                                                                    <td align="center" class="text_1" style="width: 50px">
                                                                                        <b>Year</b>
                                                                                    </td>
                                                                                    <td align="center">
                                                                                        <?php
                                                                                        $sql_prd = "select max(date)as MAXDATE,min(date)as MINDATE from " . $mysql_table_prefix . "attendence_master ";
                                                                                        $result_prd = mysql_query($sql_prd) or die("Error in : " . $sql_prd . "<br>" . mysql_errno() . " : " . mysql_error());
                                                                                        $row_prd = mysql_fetch_array($result_prd);
                                                                                        $min_year = 2014;
                                                                                        $max_year = 2015;
                                                                                        ?>    
                                                                                        <select name="year" id="year" style="width:150px; height:25px;" onChange="get_frm('get_month.php', this.value, 'div_month', '');">
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

                                                                                    <td align="left" class="text_1" style="width: 50px">
                                                                                        <b>
                                                                                            Month
                                                                                        </b>
                                                                                    </td>
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

                                                                                    <td class="text_1" align="left" style="width: 200px">
                                                                                        <input type="radio" name="radio" id="ticket_id" value="ticket_id" <?php
                                                                                        if ($radio == "ticket_id") {
                                                                                            echo "checked";
                                                                                        }
                                                                                        ?>/>Emp Id
                                                                                        <input type="radio" name="radio" id="emp_name" value="emp_name" <?php
                                                                                        if ($radio == "emp_name") {
                                                                                            echo "checked";
                                                                                        }
                                                                                        ?>/>Emp Name
                                                                                    </td>

                                                                                    <td align="left"> 
                                                                                        <input type="text" name="txt_value" id="ticket_id" value="<?= $ticket_id ?>" size="4"/>
                                                                                    </td>

                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="6" align="center" style="padding-top:5px;">
                                                                            <input name="no_refresh" type="hidden" id="no_refresh" value="<?php echo uniqid(rand()); ?>" />
                                                                            <input type="image" src="images/btn_view.jpg" name="btn_submit" id="btn_submit" value="View"/>

                                                                            <a href="javascript:;" onClick="document.location = 'month_wise_attendance.php';">
                                                                                <img src="images/submit_button_Mahima.jpg" name="over" border="0"></a>
                                                                        </td>
                                                                    </tr>
                                                                    <input type="hidden" name="plant_name" id="sub_department"value=""/>
                                                                    <input type="hidden" name="sub_department" id="sub_department"value=""/>
                                                                    <input type="hidden" name="department" id="department"value=""/>
                                                                    <input type="hidden" name="employee_type" id="employee_type"value=""/>
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
                                                                                <form action="print_month_wise_attendance.php" method="post" name="frm_print" id="frm_print" target="_blank">

                                                                                    <input type="hidden" name="print_radio" id="print_radio" value="<?= $radio ?>"/>
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
                                                                                <form action="print_month_wise_attendance_xls.php" method="post" name="frm_print_xls" id="frm_print_xls" target="_blank" style="display:inline;">
                                                                                    <input type="hidden" name="print_month" id="print_month" value="<?= $month ?>"/>
                                                                                    <input type="hidden" name="print_year" id="print_year" value="<?= $year ?>"/>
                                                                                    <input type="hidden" name="print_employee_type" id="print_employee_type" value="<?= $employee_type ?>"/>
                                                                                    <input type="hidden" name="print_ticket_id" id="print_ticket_id" value="<?= $ticket_id ?>"/>
                                                                                    <input type="hidden" name="print_department" id="print_department" value="<?= $department ?>"/>
                                                                                    <input type="hidden" name="print_sub_department" id="print_sub_department" value="<?= $sub_department ?>"/>
                                                                                    <input type="hidden" name="print_plant_name" id="print_plant_name" value="<?= $plant_name ?>"/>

                                                                                </form>
                                                                                <a href="javascript:;" onClick="frm_print_xls.submit()" class="AddMore" >Export To XLS</a>  
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr> 
                                                            <tr>
                                                                <td align="center" colspan="2">
                                                                    <div id="div_attandance_list" style="overflow:scroll;height:500px;width:1000px">
                                                                        <table align="center" width="100%" cellpadding="0" cellspacing="0" class="table1" border="1">
                                                                            <tr class="gredBg">
                                                                                <td align="center"><b>S.No.</b></td>
                                                                                <td align="center"><b>Emp Id</b></td>
                                                                                <td align="center"><b>Name/Father Name<br/>Date of Joining/Designation</b></td>
                                                                                <?
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

                                                                                    echo "<td><b>";
                                                                                    echo "$dd";
                                                                                    echo "</b></td>";

                                                                                    $i++;
                                                                                }
                                                                                ?>
                                                                                <td align="center"><b>Total</b></td>
                                                                                <td align="center"><b>P</b></td>
                                                                                <td align="center"><b>A</b></td>
                                                                                <td align="center"><b>H</b></td>
                                                                                <td align="center"><b>W</b></td>
                                                                                <?php
                                                                                $select = mysql_query("Select * from mpc_leave_master");
                                                                                $g = 0;
                                                                                while ($select_row = mysql_fetch_array($select)) {
                                                                                    ?>
                                                                                    <td align="center">
                                                                                        <b>
                                                                                            <?= $leave_name[$g] = $select_row['leave_name'] ?>
                                                                                        </b>
                                                                                    </td>
                                                                                    <?
                                                                                }
                                                                                ?>
                                                                            </tr>
                                                                            <?
                                                                            while ($row = mysql_fetch_array($result_prj)) {
                                                                                $present = 0;
                                                                                $absent = 0;
                                                                                $h = 0;
                                                                                $wo = 0;
                                                                                $Pl = 0;
                                                                                $Cl = 0;
                                                                                $HalfCl = 0;
                                                                                $Total = 0;
                                                                                ?>
                                                                                <tr <? if ($sno % 2 == 1) { ?> bgcolor="#F8F8F8" <? } ?> class="tableTxt">
                                                                                    <td align="center"><?= $sno ?><br/><?= $off_day = getweeklyoffDetail('off_day', $row['id'], $start_date) ?></td>
                                                                                    <td align="center"><?= $row['ticket_no'] ?></td>
                                                                                    <td align="left" ><?= $row['first_name'] ?> <?= getfamilyDetail('father_name', $row['id']) ?><br/><?= getDatetime(getofficeDetail('date_joining', $row['id'])) ?>/<?= getdesignationMaster('designation_name', 'rec_id', getdesignationDetail('designation_id', $row['id'], $start_date)); ?></td>
                                                                                    <?
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
                                                                                            /*                                                                                             * *********************************** */

                                                                                            $sql_to = mysql_query("SELECT off_day FROM mpc_shift_detail where emp_id = '$row[id]'");
                                                                                            $res = mysql_fetch_array($sql_to);
                                                                                            $weekoffdetails = $res['off_day'];

                                                                                            /*                                                                                             * *********************************** */
                                                                                            $weekday = date("l", mktime(0, 0, 0, $mm, $dd, $yy));
                                                                                            if (getHoliday('rec_id', $date1) != "") {
                                                                                                $date_before = date('Y-m-d', mktime(0, 0, 0, $mm, $dd - 1, $yy)) . '<br />';
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
                                                                                                    $Total++;
                                                                                                } else if ($leave_status == "HCL") {
                                                                                                    $Cl = $Cl + 0.5;
                                                                                                    $present = $present + 0.5;
                                                                                                    $Total++;
                                                                                                } elseif ($leave_status == "P/2") {
                                                                                                    $present = $present + 0.5;
                                                                                                    $absent = $absent + 0.5;
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
                                                                                                    $Total++;
                                                                                                } else if ($leave_status == "A") {
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
                                                                                                    $present = $present + 0.5;
                                                                                                    $Total = $Total + 0.5;
                                                                                                } elseif ($leave_status == "P/2") {
                                                                                                    $present = $present + 0.5;
                                                                                                    $absent = $absent + 0.5;
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
                                                                                                #echo '<br/>counting=>'.$leave_status;
                                                                                            }
                                                                                            #echo '<br/>checking=>'.$leave_status;
                                                                                        }
                                                                                        #echo '<br/>final=>'.$leave_status.'End Here';
                                                                                        echo "<td>";
                                                                                        echo $leave_status;
                                                                                        echo "</td>";
                                                                                        $i++;
                                                                                    }
                                                                                    ?>
                                                                                    <td align="center"><?= $day2 ?></td><!--Total-->
                                                                                    <td align="center"><?= $present ?></td><!--P-->
                                                                                    <td align="center"><?= $absent ?></td><!--a-->
                                                                                    <td align="center"><?= $h ?></td>
                                                                                    <td align="center"><?= $wo ?></td>
                                                                                    <?php
                                                                                    $select = mysql_query("select * from mpc_leave_master");
                                                                                    while ($result = mysql_fetch_array($select)) {
                                                                                        $results = mysql_query("SELECT count('attendance_status') as total from mpc_attendence_master where attendance_status = '$result[leave_name]' AND emp_id = $row[id] AND Month(date) = '$_REQUEST[month]'");
                                                                                        $data = mysql_fetch_assoc($results);
                                                                                        if ($result[leave_name] == "Pl") {
                                                                                            ?>
                                                                                            <td align = "center"><?= $Pl ?></td>
                                                                                            <?
                                                                                        }
                                                                                        if ($result[leave_name] == "Cl") {
                                                                                            ?>
                                                                                            <td align = "center"><?= $Cl ?></td>
                                                                                            <?
                                                                                        }
                                                                                    }
                                                                                    ?>
                                                                                </tr>
                                                                                <?
                                                                                $sno++;
                                                                            }
                                                                            ?>
                                                                            <tr>
                                                                                <td colspan="40">Note:-Attendance may be indicated by the following Symbols:P-Present   A-absent   PL-Paid Leave   C/OFF-Compensatory Off Taken   ML-Medical Leave <br/>H-Holiday   W-weekly Off   Cl-Casual Leave  HD-Half Day  AL-Absent Without Leave   AW -Allow to Work   OD-Out of Station   S-Suspend R-Return 
                                                                                </td>
                                                                            </tr>														 
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
