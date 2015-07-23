<?php
$total_al = 0;
$total_de = 0;
$mdays = 0;
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

    //echo "$today ";

    $yy = date('Y', $date);
    $mm = date('m', $date);
    $dd = date('d', $date);

    $mdays = $dd;

    $i++;
}


/* __________________________________//calculate month days//_____________________________ */

for ($i = 0; $i < $count; $i++) {
    $pay_days = 0;
    $present_days = 0;
    $woff = 0;
    $oth = 0;
    $app_days = 0;
    $total_al = 0;
    $total_de = 0;
    $total_days = 0;
    if (isset($emp_check[$i])) {
        $emp_id = $emp_check[$i];
        $query = "Select * from mpc_attendence_master where emp_id = '$emp_check[$i]' AND month(date) ='$month' AND year(date) = '$year'";
        $select = mysql_query($query);
        $total_rows = mysql_num_rows($select);
        while ($fetch = mysql_fetch_array($select)) {
            $status = $fetch['attendance_status'];
            $date = date('Y-m-d', strtotime($fetch['date']));
            if ($status == "HD") {
                $yy = date('Y', strtotime($date));
                $mm = date('m', strtotime($date));
                $dd = date('d', strtotime($date));
                $date_before = date('Y-m-d', mktime(0, 0, 0, $mm, $dd - 1, $yy));
                $date_after = date('Y-m-d', mktime(0, 0, 0, $mm, $dd + 1, $yy));
            }
            if ($date_before == $date || $date_after == $date) {
                if ($status == "p" || $status == "OD") {
                    $total_days = $total_days + 1;
                    $pay_days = $pay_days + 1;
                }
            }
            if ($status == 'P' || $status == 'OD' || $status == "w") {
                $total_days = $total_days + 1;
                $pay_days = $pay_days + 1;
            }
//____________________Present Days____________________//
            if ($status == 'P') {
                $present_days = $present_days + 1;
            }

            if ($status == 'A') {
                $app_days = $app_days + 1;
                $total_days = $total_days + 1;
            }
//__________________WeekofCount ____________________//
            if ($status == 'w') {
                $woff = $woff + 1;
                $pay_days = $pay_days + 1;
            }
//__________________Leave Days__________________//

            $leave = mysql_query("Select * from mpc_leave_master");
            while ($leave_row = mysql_fetch_array($leave)) {
                if ($leave_row['leave_name'] == $status) {
                    $total_days = $total_days + 1;
                    $pay_days = $pay_days + 1;
                }
            }
        }
//        echo $pay_days;
//        die;
        $query = "Select * from mpc_salary_master,mpc_official_detail,mpc_account_detail,mpc_employee_master,mpc_department_master,mpc_designation_master Where mpc_employee_master.emp_id = '$emp_check[$i]' AND mpc_employee_master.designation= mpc_designation_master.rec_id AND (mpc_employee_master.sub_department = mpc_department_master.rec_id OR mpc_employee_master.department = mpc_department_master.rec_id ) AND mpc_account_detail.emp_id = mpc_employee_master.emp_id AND mpc_official_detail.emp_id = mpc_employee_master.emp_id AND mpc_employee_master.emp_id =mpc_salary_master.emp_id AND mpc_salary_master.emp_id = '$emp_check[$i]'";
        $emp_select = mysql_query($query);
        while ($emp_res = mysql_fetch_array($emp_select)) {
            $emp_token = $emp_res['ticket_no'];
            $empType = $emp_res['empType'];
            $first_name = $emp_res['first_name'];
            $last_name = $emp_res['last_name'];
            $department_name = $emp_res['department_name'];
            $designation_name = $emp_res['designation_name'];
            $dob = $emp_res['dob'];
            $pf_number = $emp_res['pf_number'];
            $esic_number = $emp_res['esic_number'];
            $date_joining = $emp_res['date_joining'];
            $account_no = $emp_res['account_no'];
            $bank_name = $emp_res['bank_name'];

            $basic = ceil(($emp_res['basic'] / $mdays) * $pay_days);
            $hra = ceil(($emp_res['hra'] / $mdays) * $pay_days);
            $convence = ceil(($emp_res['convence'] / $mdays) * $pay_days);
            $site_allowance = ceil(($emp_res['site_allowance'] / $mdays) * $pay_days);
            $total_de += $tds = ceil(($emp_res['tds'] / $mdays) * $pay_days); //sub
            $total_de +=$professional_tax = ceil(($emp_res['professional_tax'] / $mdays) * $pay_days); //sub
        }
    }

    $total_al = $basic; //add
    $total_al = $hra + $total_al; //add
    $total_al = $convence + $total_al; //add
    $total_al = $site_allowance + $total_al; //add
    $total_de += $tds; //sub
    $total_de +=$professional_tax; //sub
    $total_al = $total_al;
    $total_al = ceil($total_al);
    $total_de = ceil($total_de);
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
            <div class="slip-container">
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
                        <h4>Salary Slip for the month of <?= $month . "-" . $year ?></h4>
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
                                <tr><th>Employee Name</th><td><?= $first_name . " " . $last_name ?></td></tr>
                                <tr><th>Department</th><td><?= $department_name ?></td></tr>
                                <tr><th>Designation</th><td><?= $designation_name ?></td></tr>
                                <tr><th>Present Days</th><td><?= $present_days ?></td></tr>
                                <tr><th>Total Days</th><td><?= $total_days ?></td></tr>
                                <tr><th>Date Of Birth</th><td><?= date('d-m-Y', strtotime($dob)) ?></td></tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="box50 emp-detail">
                        <table class="box100">
                            <tbody>
                                <tr><th>Site Name</th><td>Corporate Office</td></tr>
                                <tr><th>Employee Code</th><td><?= $emp_token ?></td></tr>
                                <tr><th>PF No.</th><td><?= $pf_number ?></td></tr>

                                <tr>
                                    <th>ESIC No.</th>
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
                                    <th>Date of Joining</th>
                                    <td><?= date('d-m-Y', strtotime($date_joining)) ?></td></tr>
                                <tr><th>Bank A/c No.</th><td><?= $account_no . " " . $bank_name ?></td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!---->
                <div class="row">
                    <div class="box20"><strong>Leave Avail :</strong></div>
                    <?php
                    $leave_select = mysql_query("Select * from mpc_leave_master");
                    while ($leave_view = mysql_fetch_array($leave_select)) {
                        ?>
                        <div class="box10"><strong><?= $leave_view['leave_name'] ?>:</strong>
                            <?php
                            $queryL = "Select * from mpc_attendence_master where emp_id = '$emp_id' AND attendance_status = '$leave_view[leave_name]'";
                            $selectL = mysql_query($queryL);
                            echo $totalL = mysql_num_rows($selectL);
                            ?>
                        </div>
                        <?
                    }
                    ?>
                    <div class="box10"><strong>Week Off :</strong> <?= $woff ?></div>

                </div>
                <!---->
                <div class="row">
                    <div class="box50">
                        <table class="box100 main-table">
                            <thead><tr><th colspan="3"><h3>Earning</h3></th></tr></thead>
                            <tbody>
                                <tr><th>Basic</th><td><?= $basic ?></td></tr>
                                <tr><th>HRA</th><td><?php
                                        if (!empty($hra)) {
                                            echo $hra;
                                        } else {
                                            echo "-";
                                        }
                                        ?></td></tr>
                                <tr><th>Conveyance</th><td><?= $convence ?></td></tr>
                                <tr><th>Special Allowance</th><td></td></tr>
                                <tr><th>Telephone Allowance (Conv.)</th><td>-</td></tr>
                                <tr><th>Others</th><td>-</td></tr>
                                <tr><th>Site Allowance</th><td><?php
                                        if (!empty($site_allowance)) {
                                            echo $site_allowance;
                                        } else {
                                            echo "-";
                                        }
                                        ?></td></tr>
                                <tr><th>Arrear</th><td>-</td></tr>
                            </tbody>
                            <tfoot>
                                <tr><th>Total</th><td><?= $total_al ?></td></tr>
                            </tfoot>
                        </table>          
                    </div>
                    <table class="box50 main-table">
                        <thead><tr><th colspan="3"><h3>Deduction</h3></th></tr></thead>
                        <tbody>
                            <tr><th>P.F.</th><td><?php
                                    if (!empty($pf_amount)) {
                                        echo $pf_amount;
                                    } else {
                                        echo "-";
                                    }
                                    ?></td></tr>
                            <tr>
                                <th>E.S.I.</th>
                                <td><?php
                                    if (!empty($esic)) {
                                        echo $esic;
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
                                    if (!empty($tds)) {
                                        echo $tds;
                                    } else {
                                        echo "-";
                                    }
                                    ?>
                                <td>
                            </tr>
                            <tr><th>Prfn_Tax</th><td><?php
                                    if (!empty($professional_tax)) {
                                        echo $professional_tax;
                                    } else {
                                        echo "-";
                                    }
                                    ?></td></tr>
                            <tr><th>Advance</th><td>-</td></tr>
                            <tr><th>Loan</th><td>-</td></tr>
                            <tr><th>Issued Coupon</th><td>-</td></tr>
                            <tr><th>Others</th><td>-</td></tr>
                        </tbody>
                        <tfoot>
                            <tr><th>Total</th><td><?= $total_de ?></td></tr>
                        </tfoot>
                    </table>
                </div>
                <!---->
                <div class="row slip-footer">
                    <div class="box50">
                        <h4>Total Payable Amount : <?= $total_al + $total_de ?> /-</h4>
                    </div>
                    <div class="box50">
                        Authorize Signatory
                    </div>
                </div>
            </div>
        </body>
        <?
    }?>