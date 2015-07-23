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
    $sql_prj = "select DAY(mpc_official_detail.date_joining) as 'Day',MONTH(mpc_official_detail.date_joining) as 'Month' ,YEAR(mpc_official_detail.date_joining) as 'Year',mpc_official_detail.date_joining,mpc_official_detail.employee_typ,mpc_employee_master.rec_id as id,mpc_employee_master.ticket_no,mpc_employee_master.first_name,mpc_employee_master.last_name,mpc_official_detail.emp_id,mpc_account_detail.date_releaving $select_string ,date_releaving,mpc_good_work_master.good_work,mpc_good_work_master.date as good_work_date,mpc_good_work_master.emp_id as ot_emp_id from " . $mysql_table_prefix . "employee_master,mpc_official_detail,mpc_good_work_master,mpc_account_detail $table_list where mpc_employee_master.rec_id!='' and  mpc_employee_master.rec_id=mpc_official_detail.emp_id and EXTRACT(YEAR_MONTH FROM mpc_official_detail.date_joining)<='$year$month' and mpc_employee_master.rec_id=mpc_account_detail.emp_id and mpc_good_work_master.emp_id = mpc_employee_master.rec_id and mpc_account_detail.date_releaving ='0000-00-00' $where_string order by mpc_employee_master.ticket_no  ASC ";

    $result_prj = mysql_query($sql_prj) or die("Error in Query :" . $sql_prj . "<br>" . mysql_error() . ":" . mysql_errno());
}
?>
<style>
    select,input[type="text"]{height:36px !important; width:185px !important;margin:5px 0;}
</style>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
    <tr>
        <td style="padding-left:5px; padding-top:5px;" valign="top">
            <table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
                <tr>
                    <th align="center">Laxyo Solution Soft Pvt. Ltd.</th>
                </tr>
                <tr>
                    <th align="left">Over Time Register MONTH -
                        <?= @date("F", mktime(0, 0, 0, $month, 1, 0)) ?>
                        ,
                        <?= $year ?></th>
                </tr>
                <tr>
                    <td valign="top">
                        <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td>
                                    <table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
                                        <tr>
                                            <td align="center" valign="top" style="padding-top:5px;">
                                                <table align="center" width="100%" cellpadding="1" cellspacing="1" border="0" style="border:1px solid #E4E4E4;">
                                                    <?
                                                    if (isset($_POST["btn_submit_x"]) or isset($_GET['month'])) {
                                                        if (mysql_num_rows($result_prj) > 0) {
                                                            $sno = $start + 1;
                                                            $grand_ot = 0;
                                                            ?>
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
                                                                                    $d = $yy . "/" . $mm . "/" . $dd;
                                                                                    echo "<td><b>";
                                                                                    echo "$dd";
                                                                                    echo "</b></td>";
                                                                                    $i++;
                                                                                }
                                                                                ?>
                                                                                <td align="center"><b>OT Hours</b></td>
                                                                                <td align="center"><b>Remark</b></td>
                                                                            </tr>
                                                                            <?php
                                                                            $no = 1;
                                                                            $result = mysql_query("SELECT DISTINCT emp_id FROM mpc_good_work_master");
                                                                            while ($fetch = mysql_fetch_array($result)) {
                                                                                ?>
                                                                                <tr>
                                                                                    <td>
                                                                                        <?= $no ?>
                                                                                    </td>
                                                                                    <td>
                                                                                        <?php
                                                                                        $emp_det = mysql_query("Select * from mpc_employee_master where emp_id = $fetch[emp_id]");
                                                                                        $emp_det_fetch = mysql_fetch_array($emp_det);
                                                                                        echo $emp_det_fetch['ticket_no'];
                                                                                        ?>
                                                                                    </td>
                                                                                    <td>
                                                                                        <?= $emp_det_fetch['first_name'] . " " . $emp_det_fetch['last_name'] ?>
                                                                                    </td>
                                                                                    <?php
                                                                                    $tot_ot = 0;

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
                                                                                        $d = $yy . "/" . $mm . "/" . $dd;

                                                                                        $sot = mysql_query("Select *,DAY(date)as day from mpc_good_work_master where emp_id = $fetch[emp_id] and date = '$d'");
                                                                                        echo "<td>";
                                                                                        while ($fot = mysql_fetch_array($sot)) {
                                                                                            if ($dd == $fot['day']) {
                                                                                                echo $good_work = str_replace(":", ".", "$fot[good_work]");

                                                                                                $tot_ot = $tot_ot + $good_work;
                                                                                            }
                                                                                        }
                                                                                        echo "</td>";
                                                                                        $i++;
                                                                                    }
                                                                                    $grand_ot = $tot_ot + $grand_ot;
                                                                                    ?>
                                                                                    <td>
                                                                                        <?= $tot_ot ?>
                                                                                    </td>
                                                                                    <td></td>
                                                                                </tr>
                                                                                <?
                                                                                $no++;
                                                                            }
                                                                            ?>
                                                                            <tr>
                                                                                <td colspan="<?= $dd + 3 ?>" align='right '>
                                                                                    Total 
                                                                                </td>
                                                                                <td>
                                                                                    <?= $grand_ot ?>
                                                                                </td>
                                                                                <td></td>
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
<? include ("inc/hr_footer.php"); ?>	
<style>
    @media print {
        thead {display: table-header-group;}
    }
</style>
<script>
    window.print();
</script> 

