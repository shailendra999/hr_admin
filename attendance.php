<?php
session_start();
$request = $_REQUEST['editReq'];
$user_name = $_SESSION['hr_mahima_session_user_name'];
$date = date("Y-m-d h:i:sa");
$folder = explode("/", $_SERVER["PHP_SELF"]);
$folder = $folder[1];
if (isset($_REQUEST['save_request'])) {
    $date_req = $_REQUEST['req_date'];
    $req_reason = $_REQUEST['req_reason'];
    $req_details = $_REQUEST['req_details'];
    $req_page = $_REQUEST["req_page"];
    $req_plant = $_REQUEST["req_plant"];
    $req_user = $_REQUEST["req_user"];
    $temp_con = @mysql_connect('localhost', 'ssofts_lss', 'ssoftslss')or die("Couldn't connect to server.");
    if (!$temp_con) {
        echo mysql_errno() . " " . "Db is not connected";
    } else {
        $temp_db = mysql_select_db('ssofts_adminlss', $temp_con)or die("Couldn't select database.");
        if (!$temp_db) {
            echo mysql_errno() . " " . "Db is not selected ";
        }
    }
    $inQuery = "INSERT INTO `ssofts_adminlss`.`request` ( `plant_name`, `plant_hr`, `request_reason`, `request_description`, `request_page`, `request_date`) VALUES ('$req_plant','$req_user','$req_reason','$req_details','$req_page','$date')";
    $insert = mysql_query($inQuery);
    mysql_close($temp_con);
}
?>
<?php include ("inc/hr_header.php"); ?>
<script language = "JavaScript">
    function openWindow(url, id) {
        window.showModalDialog(url + "?id=" + id, window, 'dialogWidth:800px; dialogHeight:800px');
    }
</script>
<script type="text/javascript" src="javascript/common_function.js"></script>
<script type="text/javascript" src="javascript/form.js"></script>
<script type="text/javascript" src="javascript/popup.js"></script>
<script>
    function overlay(id) {
        el = document.getElementById("overlay");
//        document.getElementById("hidden_overlay").value = id;
        el.style.visibility = (el.style.visibility == "visible") ? "hidden" : "visible";

    }
</script>
<?
$user_name = $_SESSION['hr_mahima_session_user_name'];
$folder = explode("/", $_SERVER["PHP_SELF"]);
$folder = $folder[1];
//include ("inc/function.php");
?>
<form id="frm_emp_list" name="frm_emp_list" method="POST">
    <table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
        <tr>
            <td align="left" valign="top" width="230px" style="padding-top:5px;">
                <? include ("inc/snb.php"); ?>
            </td>

            <td style="padding-left:5px; padding-top:5px; vertical-align:top">
                <table cellspacing="0" cellpadding="0" border="0" align="center" width="100%">
                    <tr>
                        <td align="center" class="gray_bg">&nbsp; <a href="#" style="text-decoration:none;color:gray;">Attendance master-> </a>attendance as per date for all employee</td>
                    </tr>
                    <tr>
                        <td>
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">

                                <tr id="msg">
                                    <?= $msg ?>
                                </tr>
                                <tr>
                                    <td width="100%" colspan="2" align="center">
                                        <table cellpadding="0" cellspacing="0" border="0" align="center" class="loginbg" >
                                            <tr>
                                                <td class="text_1" style="padding-left:15px;" width="12%">Attendance Date<span class="red">*</span></td>
                                                <td>
                                                    <select name="atten_typ" id="atten_typ" onchange="getDatebox(this.value);">
                                                        <option value="1">Daily</option>
                                                        <option value="2">Monthly</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" name="txt_date" id="txt_date" value="" style="width:100px; height:20px;"data-beatpicker="true" data-beatpicker-format="['DD','MM','YYYY']"/>
                                                </td>
                                                <td style="display: none" id="to_td">
                                                    <input type="text" name="txt_date1" id="txt_date1" value="" style="width:100px; height:20px;"data-beatpicker="true" data-beatpicker-format="['DD','MM','YYYY']"/>
                                                </td>
                                                <td width="7%" class="text_1" style="padding-right:15px; text-align:right;">
                                                    Type
                                                </td>
                                                <td width="13%">
                                                    <select id="employee_type" name="employee_type" onChange="empTypeFltr(this.value, 'get-emp-by-typ.php', '')" style="width:100px; height:25px;" onkeydown="if (event.keyCode && event.keyCode == 13) {

                                                            }">
                                                        <option value="all">All</option>
                                                        <?php
                                                        $que = mysql_query("select type_name from mpc_employee_type_master");

                                                        while ($row = mysql_fetch_array($que)) {
                                                            ?>
                                                            <option value="<?php echo $row['type_name'] ?>"><?php echo $row['type_name']; ?> </option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" value="" id="mon_employee_id" onkeyup="empTypeFltr(employee_type.value, 'get-emp-by-typ.php', this.value)"/>
                                                </td>

                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <!--form action="" name="save_attendance" id="save_attendance" method="post"-->
                            <?php
                            session_start();
                            $session_palnt_id = $_SESSION['session_user_plant'];
                            $filter_sql = "";
                            if (isset($_GET['ticket_no'])) {
                                $ticket_no = $_GET['ticket_no'];
                                $filter_sql = "and ticket_no ='$ticket_no'";
                            }
                            /* $sql = mysql_query("Select mpc_employee_master.*, mpc_department_master.* 
                              from mpc_department_master RIGHT JOIN mpc_employee_master
                              ON mpc_department_master.rec_id = mpc_employee_master.department
                              JOIN mpc_plant_employee ON mpc_employee_master.$filter_sql ORDER BY mpc_employee_master.rec_id");
                             */
                            $sql = mysql_query("Select * From mpc_employee_master,mpc_department_master,mpc_plant_employee where mpc_department_master.rec_id = mpc_employee_master.department  AND mpc_employee_master.emp_id = mpc_plant_employee.emp_id ORDER BY mpc_employee_master.rec_id");
                            $count = 1;
                            ?>

                            <table width="100%" cellspacing="2" cellpadding="2" border="0" align="center" class="border">
                                <thead class="blackHead" style="text-align: center">
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Department</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody bgcolor="#F8F8F8" class="tableTxt" style="text-align: center" id='tab'>
                                    <?php
                                    $num_rows = mysql_num_rows($sql);
                                    $j = 0;
                                    while ($row_emp = mysql_fetch_array($sql)) {
                                        ?>
                                        <tr>
                                            <td>
                                                <input type="hidden" name="emp<?= $j ?>" id="emp" value="<?= $row_emp['emp_id'] ?>"/>
                                                <?php echo $row_emp['ticket_no']; ?>
                                            </td>
                                            <td>
                                                <?php echo strtoupper($row_emp['first_name']) . "&nbsp;" . strtoupper($row_emp['last_name']); ?>
                                            </td>
                                            <td>
                                                <?php
                                                $q = mysql_query("Select * from mpc_department_master where rec_id = $row_emp[department]");
                                                $row = mysql_fetch_array($q);
                                                echo strtoupper($row['department_name']);
                                                ?>
                                            </td>
                                            <td>
                                                <div class="categoryitems subLinks" style="height:auto;">
                                                    <select name="attendace<?= $j ?>" id="attendace" onchange="myfunction(this.value)">
                                                        <option value="P" <?php
                                                        if ($data['attendance'][$i] == $a['leave_name']) {
                                                            echo 'selected="selected"';
                                                        }
                                                        ?>>Present</option>
                                                        <option value="P/2">Present/2</option>
                                                        <option value="A">Absent</option>
                                                        <option value="HCL">Half Day</option>
                                                        <option value="C/OFF">C/OFF</option>
                                                        <?php
                                                        $que = mysql_query("SELECT * FROM `mpc_leave_master` ");
                                                        while ($a = mysql_fetch_array($que)) {
                                                            ?>
                                                            <option value="<?php echo $a['leave_name']; ?>" <?php
                                                            if ($data['attendance'][$i] == $a['leave_name']) {
                                                                echo 'selected="selected"';
                                                            }
                                                            ?> ><?php echo $a['leave_name']; ?></option>
                                                                <?php } ?>
                                                    </select>
                                                </div>
                                            </td>

                                        </tr>
                                        <?php
                                        $j++;
                                    }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td style="text-align: right" colspan="3">
                                            <input type="hidden" name="count" id="count" value="<?= $num_rows ?>"/>
                                            <?php
                                            if (isset($_REQUEST['request_form'])) {
                                                ?>
                                                <input type="hidden" name="request_form" id="request_form" value="1"/>
                                                <?
                                            }
                                            ?>
                                            <?php
                                            if (isset($_REQUEST['editReq'])) {
                                                ?>
                                                <input type="hidden" name="check_status" id="check_status" value="1"/>
                                                <?php
                                            }
                                            ?>
                                        </td>
                                        <td style="text-align: center" >
                                            <input type="submit" name="save_status" id="save_status" value="Submit"/>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                            <!--/form-->
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

</form>

<div id="overlay">
    <div>
        <form name="request_form" action="" method="post">
            <table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
                <tr>
                    <td colspan="2" class="blackHead">Edit Request</td>
                </tr>
                <tr>
                    <td align="left" valign="top">
                        <table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
                            <tr>
                                <td class="text_1" valign="top">Request Date</td>
                                <td><?= date("Y-m-d") ?></td>
                            </tr>
                            <tr>
                                <td class="text_1" valign="top">Reason</td>
                                <td><textarea id="req_reason" name="req_reason"></textarea></td>
                            </tr>
                            <tr>
                                <td class="text_1" valign="top">Details</td>
                                <td>
                                    <textarea id="req_details" name="req_details"></textarea>
                                    <?php $page = "attendance.php"; ?>
                                    <input type="hidden" name="req_page" id="req_page" value="<?= $page ?>"/>
                                    <input type="hidden" name="req_plant" id="req_plant" value="<?= $folder ?>"/>
                                    <input type="hidden" name="req_user" id="req_user" value="<?= $user_name ?>"/>
                                </td>
                            </tr>
                        </table>
                    </td>

                    <td>

                    </td>
                </tr>
                <tr>
                    <td colspan="2" align="center">
                        <input type="submit" name="save_request" id="save_request" value="Send"/>
                    </td>
                </tr>
            </table>
            <input type="button" class="btn_bg1" onClick="overlay();" name="btn_close" value="No" />
        </form>
    </div>
</div>
<?php
if (isset($_REQUEST['save_status'])) {
    $count = $_REQUEST['count'];

    $date = date('Y-m-d', strtotime($_REQUEST['txt_date']));

    if (isset($_REQUEST['txt_date']) && isset($_REQUEST['txt_date1'])) {
        $txt_date1 = $_REQUEST['txt_date'];
        $txt_date2 = $_REQUEST['txt_date1'];
        $d1 = date("Y-m-d", strtotime($txt_date1));
        $d2 = date("Y-m-d", strtotime($txt_date2));
        $check = mysql_query("Select * from mpc_attendence_master where date between '$d1' AND '$d2'");
        if (!isset($_REQUEST['request_form'])) {
            if (mysql_num_rows($check) > 0) {
                if (isset($_REQUEST['check_status'])) {
                    
                } else {
                    ?>
                    <script >
                        overlay("1");
                    </script> 
                    <?php
                    die;
                }
            }
        }
        $ip = $_SERVER['REMOTE_ADDR'];

        $good_work = "";

        $txt_date1 = str_replace("/", "-", $txt_date1);
        $txt_date2 = str_replace("/", "-", $txt_date2);

        $datePeriods = createDateRangeArray($txt_date1, $txt_date2);
        for ($d = 1; $d < $count; $d++) {
            $emp_id = $_REQUEST['emp' . $d];
            $id = $emp_id;
            $attendace = $_REQUEST['attendace' . $d];
            $status = $attendace;

////////////////////// Markin attendence //////////////

            date_default_timezone_set('UTC');
            $date = $txt_date1;
// End date
            $end_date = $txt_date2;

            while (strtotime($date) <= strtotime($end_date)) {

                $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
            }
            $dayofweek = date('w', strtotime($date));
            $result = date('Y-m-d', strtotime(($day - $dayofweek) . ' day', strtotime($date)));

            foreach ($datePeriods as $datePeriod) {
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
                        $status = $attendace;
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
                        $status = $attendace;
                    }
                }
                if ($b == "1") {
                    $status = $attendace;
                }
            }
        }
    } else {
        /* /* Daily attendance insert update ************** / */
        for ($c = 1; $c < $count; $c++) {

            $emp_id = $_REQUEST['emp' . $c];
            $attendace = $_REQUEST['attendace' . $c];
            $sql = mysql_query("select emp_id from mpc_employee_master where ticket_no='$emp_id'");
            $r = mysql_fetch_array($sql);
            $sql = "select * from mpc_attendence_master where emp_id = '$emp_id' and date = '$date'";

            $result_doc = mysql_query($sql) or die("Error in : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());

            if ($rows = mysql_num_rows($result_doc) > 0) {
                $sql_check_update = "update " . $mysql_table_prefix . "attendence_master set	
				attendance_status='$attendace[$i]',badli_as ='$badli_as',
				shift ='$shift'where emp_id ='$r[emp_id]' and date ='$date'";
                $result_check_update = mysql_query($sql_check_update) or die("Query Failed " . mysql_error());
                if (!$result_check_update) {
                    echo "Data is not inserted ";
                } else {
                    echo "Data is inserted..";
                }
            } else {
                $sqll = mysql_query("insert into mpc_attendence_master (emp_id,attendance_status,shift,date,time,time_out) values ('$emp_id','$attendace','$shift','$date','now()','now()') ");
            }
            if (!$sqll) {
                $msg = "Data is not inserted ";
            } else {
                $msg = "Data is inserted..";
            }
        }
    }
}

function createDateRangeArray($sStartDate, $sEndDate) {

    $sStartDate = gmdate("Y-m-d", strtotime($sStartDate));
    $sEndDate = gmdate("Y-m-d", strtotime($sEndDate));
    $aDays[] = $sStartDate;
    $sCurrentDate = $sStartDate;
    while ($sCurrentDate < $sEndDate) {
        $sCurrentDate = gmdate("Y-m-d", strtotime("+1 day", strtotime($sCurrentDate)));
        $aDays[] = $sCurrentDate;
    }
    return $aDays;
}
?>

<script>

    function getDatebox(typ) {
        if (typ == "2") {
            document.getElementById('to_td').style.display = "block";
        }
        if (typ == "1") {
            document.getElementById('to_td').style.display = "none";
        }
    }

    function empTypeFltr(typName, url, emp_id) {

        xmlHttp1 = GetXmlHttpObject1();
        if (xmlHttp1 == null)
        {
            alert("Browser does not support HTTP Request")
            return;
        }
        document.getElementById('tab').innerHTML = '<img src="images/ajax_loader.gif" border="0">';
        url = url + "?id=" + typName + "&str=" + emp_id + "&str2=" + Math.random();
        xmlHttp1.onreadystatechange = function ()
        {
            if (xmlHttp1.readyState == 4 || xmlHttp1.readyState == "complete")
            {
                document.getElementById('tab').innerHTML = xmlHttp1.responseText;
            }
        };
        xmlHttp1.open("GET", url, true)
        xmlHttp1.send(null)

    }
</script>
