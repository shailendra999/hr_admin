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

if (isset($_POST["print_employee_type"]) and isset($_POST["print_ticket_id"]) and isset($_POST["print_department"]) and isset($_POST["print_sub_department"])
        and isset($_POST["print_plant_name"])) {
    if (($_POST["print_employee_type"] != "")) {
        $select_string = ",mpc_designation_employee.*,mpc_designation_master.*";
        $employee_type = $_POST["print_employee_type"];
        $table_list = ",mpc_designation_employee,mpc_designation_master";
        $where_string.="and mpc_designation_employee.emp_id =mpc_employee_master.rec_id and mpc_designation_employee.designation_id=mpc_designation_master.rec_id and mpc_designation_master.emp_category='$employee_type' and mpc_designation_employee.to_date='0000-00-00'";
    }
    if ($_POST["print_ticket_id"] != "") {
        $select_string = "";
        $ticket_id = $_POST["print_ticket_id"];
        $table_list.= "";
        if ($_REQUEST['print_radio'] == 'emp_name') {
            $where_string.="and mpc_employee_master.first_name LIKE '$ticket_id%'";
        }
        if ($_REQUEST['print_radio'] == 'ticket_id') {
            $where_string.="and mpc_employee_master.ticket_no ='$ticket_id'";
        }
    }
    if ($_POST["print_department"] != "" and $_POST["print_sub_department"] == "") {
        $select_string = ",mpc_department_employee.*,mpc_department_master.*";
        $department = $_POST["print_department"];
        $table_list.= ",mpc_department_employee,mpc_department_master";

        $where_string.="and mpc_department_employee.emp_id =mpc_employee_master.rec_id and mpc_department_master.reference_id ='$department' and mpc_department_employee.to_date='0000-00-00' and mpc_department_master.rec_id=mpc_department_employee.dept_id";
    }
    if ($_POST["print_sub_department"] != "") {
        $select_string = ",mpc_department_employee.*";
        $department = $_POST["print_department"];
        $sub_department = $_POST["print_sub_department"];
        $table_list.= ",mpc_department_employee";

        $where_string.="and mpc_department_employee.emp_id =mpc_employee_master.rec_id and mpc_department_employee.dept_id ='$sub_department' and mpc_department_employee.to_date='0000-00-00'";
    }
    if ($_POST["print_plant_name"] != "") {
        $select_string = ",mpc_plant_employee.*";
        $plant_name = $_POST["print_plant_name"];
        $table_list.= ",mpc_plant_employee";

        $where_string.="and mpc_plant_employee.emp_id =mpc_employee_master.rec_id and mpc_plant_employee.plant_id ='$plant_name' and mpc_plant_employee.to_date='0000-00-00'";
    }
}
if (isset($_POST["btn_submit_x"]) or isset($_GET['month'])) {
    $sql_prj = "select DAY(mpc_official_detail.date_joining) as 'Day',MONTH(mpc_official_detail.date_joining) as 'Month' ,YEAR(mpc_official_detail.date_joining) as 'Year',mpc_official_detail.date_joining,mpc_official_detail.employee_typ,mpc_employee_master.rec_id as id,mpc_employee_master.ticket_no,mpc_employee_master.first_name,mpc_employee_master.last_name,mpc_official_detail.emp_id,mpc_account_detail.date_releaving $select_string from " . $mysql_table_prefix . "employee_master,mpc_official_detail,mpc_account_detail $table_list where mpc_employee_master.rec_id!='' and mpc_employee_master.rec_id=mpc_official_detail.emp_id and EXTRACT(YEAR_MONTH FROM mpc_official_detail.date_joining)<='$year$month' and mpc_employee_master.rec_id=mpc_account_detail.emp_id and mpc_account_detail.date_releaving ='0000-00-00' $where_string  order by mpc_employee_master.ticket_no  ASC ";

    $result_prj = mysql_query($sql_prj) or die("Error in Query :" . $sql_prj . "<br>" . mysql_error() . ":" . mysql_errno());
}
?>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
    <tr>
        <td style="padding-left:5px; padding-top:5px;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
                <thead>
                    <tr>
                        <th align="center">Laxyo Solution Soft Pvt. Ltd.</th>
                    </tr>
                    <tr>
                        <th align="left">Attendance Register MONTH -
                            <?= @date("F", mktime(0, 0, 0, $month, 1, 0)) ?>
                            ,
                            <?= $year ?></th>
                    </tr>
                    <tr>
                        <th align="left">Attendance Sheet for
                            <?
                            if ($_POST["print_plant_name"] != "") {
                                echo '-Plant :' . $_POST["print_plant_name"];
                            }

                            if ($_POST["print_employee_type"] != "") {
                                echo '-Employee Type :' . $_POST["print_employee_type"];
                            }
                            if ($_POST["print_department"] != "") {
                                echo '-Department :' . getdeptDetail('department_name', 'rec_id', $_POST["print_department"]);
                            }
                            if ($_POST["print_sub_department"] != "") {
                                echo '-Sub Department :' . getdeptDetail('department_name', 'rec_id', $_POST["print_sub_department"]);
                            }
                            if ($_POST["print_ticket_id"] != "") {
                                echo '-Employee ID.:' . $_POST["print_ticket_id"];
                            }
                            ?></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td valign="top"><?php
                            if (mysql_num_rows($result_prj) > 0) {
                                $sno = $start + 1;
                                ?>
                                <table align="center" width="100%" cellpadding="0" cellspacing="0" class="table1" border="1">
                                    <thead>
                                        <tr class="gredBg">
                                            <td width="5%" align="center"><b>S.No.</b></td>
                                            <td width="5%" align="center"><b>Emp Id</b></td>
                                            <td width="25%" align="center"><b>Name/Father Name<br/>
                                                    Date of Joining/Designation</b></td>
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

                                            @$date = mktime(0, 0, 0, $month1, $day1, $year1); //Gets Unix timestamp START DATE
                                            @$date1 = mktime(0, 0, 0, $month2, $day2, $year2); //Gets Unix timestamp END DATE
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
                                                //echo "$today ";

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
                                            <td align="center"><b>PL</b></td>
                                            <td align="center"><b>CL</b></td>
                                            <td align="center"><b>H</b></td>
                                            <td align="center"><b>W</b></td>
                                        </tr>
                                    </thead>
                                    <?
                                    while ($row = mysql_fetch_array($result_prj)) {
                                        $present = 0;
                                        $absent = 0;
                                        $h = 0;
                                        $wo = 0;
                                        $Pl = 0;
                                        $Cl = 0;
                                        $Total = 0;
                                        ?>
                                        <tr <? if ($sno % 2 == 1) { ?> bgcolor="#F8F8F8" <? } ?> class="tableTxt">
                                            <td width="5%" align="center"><?= $sno ?>
                                                <br/>
                                                <?= $off_day = getweeklyoffDetail('off_day', $row['id'], $start_date) ?></td>
                                            <td width="5%" align="center"><?= $row['ticket_no'] ?></td>
                                            <td width="15%" align="left"><?= $row['first_name'] ?>
                                                <?= getfamilyDetail('father_name', $row['id']) ?>
                                                <br/>
                                                <?= getDatetime(getofficeDetail('date_joining', $row['id'])) ?>
                                                /
                                                <?= getdesignationMaster('designation_name', 'rec_id', getdesignationDetail('designation_id', $row['id'], $start_date)); ?></td>
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
                                                    /*                                                     * *********************************** */

                                                    $sql_to = mysql_query("SELECT off_day FROM mpc_shift_detail where emp_id = '$row[id]'");
                                                    $res = mysql_fetch_array($sql_to);
                                                    $weekoffdetails = $res['off_day'];

                                                    /*                                                     * *********************************** */
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
//                                                                                                    $absent++;
                                                        }
                                                        if ($before_date == 'P' or $before_date == 'OD' or $after_date == 'P' or $after_date == 'OD' or $before_date == 'HCL' or $after_date == 'HCL') {
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
                                                $results = mysql_query("SELECT count('attendance_status') as total from mpc_attendence_master where attendance_status = '$result[leave_name]' AND emp_id = $row[id] AND Month(date) = '$_REQUEST[print_month]'");
                                                $data = mysql_fetch_assoc($results);
                                                ?>
                                                <td align = "center"><?= $data['total'] ?></td>
                                                <?
                                            }
                                            ?>
                                        </tr>
                                        <?
                                        $sno++;
                                    }
                                    ?>
                                    <tr>
                                        <td colspan="40">Note:-Attendance may be indicated by the following Symbols:P-Present   A-absent   PL-Paid Leave   CO/COF-Compensarory Off Taken   ML-Medical Leave <br/>
                                            H-Holiday   W-weekly Off   Cl-Casual Leave  HD-Half Day  AL-Absent Without Leave   AW -Allow to Work   OD-Out of Station   S-Suspend R-Return </td>
                                    </tr>
                                </table>
                                </div></td>
                        </tr>
                        <?
                    } else {
                        ?>
                        <tr class="table_rows">
                            <td align="center" colspan="8">No records found</td>
                        </tr>
                        <?
                    }
                    ?>
                </tbody>
            </table></td>
    </tr>
</table>
<style>
    @media print {
        thead {display: table-header-group;}
    }
</style>
<script>
    window.print();
</script> 
