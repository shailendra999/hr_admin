<?php
error_reporting(0);
session_start();
$user_name = $_SESSION['hr_mahima_session_user_name'];
$date = date("Y-m-d h:i:sa");
$folder = explode("/", $_SERVER["PHP_SELF"]);
$folder = $folder[1];
$id = $_GET["id"];
if (isset($_REQUEST['save_request'])) {
    $date_req = $_REQUEST['req_date'];
    $req_reason = $_REQUEST['req_reason'];
    $req_details = $_REQUEST['req_details'];
    $emp_id = $_REQUEST["emp_id"];
    $req_page = $_REQUEST["req_page"];
    $req_plant = $_REQUEST["req_plant"];
    $req_user = $_REQUEST["req_user"];
    $temp_con = mysql_connect('localhost', 'ssofts_lss', 'ssoftslss')or die("Couldn't connect to server.");
    if (!$temp_con) {
        echo mysql_errno() . " " . "Db is not connected";
    } else {
        $temp_db = mysql_select_db('ssofts_adminlss', $temp_con)or die("Couldn't select database.");
        if (!$temp_db) {
            echo mysql_errno() . " " . "Db is not selected ";
        }
    }
    $inQuery = "INSERT INTO `ssofts_adminlss`.`request` ( `plant_name`, `plant_hr`, `request_reason`, `request_description`, `request_page`, `request_date`,`emp_id`) VALUES ('$req_plant','$req_user','$req_reason','$req_details','$req_page','$date','$emp_id')";
    $insert = mysql_query($inQuery);
    mysql_close($temp_con);
}
include("inc/hr_header.php");
?>

<script language="JavaScript">
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
        document.getElementById("hidden_overlay").value = id;
        el.style.visibility = (el.style.visibility == "visible") ? "hidden" : "visible";

    }
</script>
<script>
    function show_div() {
        el = document.getElementById("div_hide");
        el.style.display = (el.style.display == "block") ? "none" : ":block";
        e2 = document.getElementById("div_show");
        e2.style.display = (e2.style.display == "none") ? "block" : "none";

    }
</script>
<script>
    function show_tab(id) {

        if (id == 1)
        {
            el = document.getElementById("menu_item1");
            el.className = "current";

            d1 = document.getElementById("tab_content1");
            d1.className = "current";

            e2 = document.getElementById("menu_item2");
            e2.className = "";

            d2 = document.getElementById("tab_content2");
            d2.className = "simpleTabsContent";
        }
        if (id == 2)
        {
            el = document.getElementById("menu_item1");
            el.className = "";

            d1 = document.getElementById("tab_content1");
            d1.className = "simpleTabsContent";

            e2 = document.getElementById("menu_item2");
            e2.className = "current";

            d2 = document.getElementById("tab_content2");
            d2.className = "current";
        }
    }
</script>
<script language="javascript">
    function openWin(url, w, h, scroll, pos)
    {
        if (pos == "center") {
            LeftPosition = (screen.width) ? (screen.width - w) / 2 : 100;
            TopPosition = (screen.height) ? (screen.height - h) / 2 : 100;
        }
        else if ((pos != "center" && pos != "random") || pos == null) {
            LeftPosition = 0;
            TopPosition = 20
        }
        settings = 'width=' + w + ',height=' + h + ',top=' + TopPosition + ',left=' + LeftPosition + ',scrollbars=' + scroll + ',location=no,directories=no,status=no,menubar=no,toolbar=no,resizable=no';
        var mywin = window.open(url, "winImage", settings);
    }
</script>
<?
$msg = "";
////////////////////// PF detail //////////////
if (isset($_POST['submit_pf'])) {

    $emp_id = $_POST['emp_id'];
    $pf_no = $_POST['pf_no'];
    $pf_rate = $_POST['pf_rate'];
    $pf_nominee = $_POST['pf_nominee'];
    $pf_relationship = $_POST['pf_relationship'];
    $esic_no = $_POST['esic_no'];
    $esic_rate = $_POST['esic_rate'];
    $esic_nominee = $_POST['esic_nominee'];
    $esic_relationship = $_POST['esic_relationship'];
    $ip = $_SERVER['REMOTE_ADDR'];

    if (isset($_POST['update'])) {
        $sql_check = "update " . $mysql_table_prefix . "account_detail set pf_number ='$pf_no',
                     pf_nominee ='$pf_nominee',pf_rate ='$pf_rate',pf_relationship ='$pf_relationship',
                     esic_number ='$esic_no',esic_nominee ='$esic_nominee',esic_rate ='$esic_rate',
                     esic_relationship ='$esic_relationship',InsertBy ='$pf_no',
                     InsertDate =now(),IpAddress ='$ip'where emp_id ='$emp_id' ";

        $result_check = mysql_query($sql_check) or die("Query Failed " . mysql_error());
    } else {
        $sql_check = "insert into " . $mysql_table_prefix . "account_detail set	emp_id ='$emp_id',
                      pf_number ='$pf_no',pf_nominee ='$pf_nominee',pf_rate ='$pf_rate',
                      pf_relationship ='$pf_relationship',esic_number ='$esic_no',
                      esic_nominee ='$esic_nominee',esic_rate ='$esic_rate',
                      esic_relationship ='$esic_relationship',InsertBy ='$pf_no',
                      InsertDate =now(),IpAddress ='$ip'";

        $result_check = mysql_query($sql_check) or die("Query Failed " . mysql_error());
    }
}
?>
<?
////////////////////// PF detail //////////////
if (isset($_POST['submit_releaving'])) {

    $emp_id = $_POST['emp_id'];
    $releaving_date = $_POST['releaving_date'];
    $releaving_reason = $_POST['releaving_reason'];
    $ip = $_SERVER['REMOTE_ADDR'];

    $sql_check = "update " . $mysql_table_prefix . "account_detail set date_releaving  ='$releaving_date',
                 reason_realeaving ='$releaving_reason',InsertBy ='$releaving_reason',InsertDate =now(),
                 IpAddress ='$ip' where emp_id='$emp_id'";

    $result_check = mysql_query($sql_check) or die("Query Failed " . mysql_error());
}
?>
<?
////////////////////// shift detail //////////////
if (isset($_POST['submit_shift'])) {

    $emp_id = $_POST['emp_id'];
    $rotation_type = $_POST['rotation_type'];
    $shift_duration = $_POST['shift_duration'];
    $off_days = $_POST['off_days'];
    $ip = $_SERVER['REMOTE_ADDR'];

    $sql_check = "insert into  " . $mysql_table_prefix . "shift_detail set emp_id  ='$emp_id',
                  rotation_type ='$rotation_type',
                  shift='$shift_duration',off_day='$off_days',InsertBy ='$emp_id',
                  InsertDate =now(),IpAddress ='$ip'";

    $result_check = mysql_query($sql_check) or die("Query Failed " . mysql_error());
}
?>
<?
////////////////////// advance detail //////////////
if (isset($_POST['issue_advance'])) {

    $emp_id = $_POST['emp_id'];
    $issue_advance = $_POST['issue_advance'];
    $ip = $_SERVER['REMOTE_ADDR'];

    $sql_check = "insert into  " . $mysql_table_prefix . "advance_employee set emp_id  ='$emp_id',"
            . "advance ='$issue_advance',ad_date =now()";

    $result_check = mysql_query($sql_check) or die("Query Failed " . mysql_error());
}

////////////////////// loan detail //////////////
if (isset($_POST['issuse_loan'])) {
    $emp_id = $_POST['emp_id'];
    $issuse_loan = $_POST['issuse_loan'];
    $decide_install = $_POST['decide_install'];
    $ip = $_SERVER['REMOTE_ADDR'];

    $sql_check = "insert into  " . $mysql_table_prefix . "loan_employee set emp_id  ='$emp_id',"
            . "loan_amount ='$issuse_loan',installments_decided ='$decide_install',"
            . "loan_date =now()";

    $result_check = mysql_query($sql_check) or die("Query Failed " . mysql_error());
}

////////////////////// salary detail //////////////
if (isset($_POST['submit_salary_x'])) {

    $emp_id = $_POST['emp_id'];

    $ip = $_SERVER['REMOTE_ADDR'];

    $basic = $_POST['salary_basic'];
    $lta = $_POST['salary_lta'];
    $convence = $_POST['convence'];
    $medical = $_POST['medical'];
    $hra = $_POST['salary_hra'];
    $side_allowance = $_POST['side_allowance'];

    $p_tax = $_POST['professional_tax'];
    $tds = $_POST['tds'];
    $other_gain = $_POST['other_deduction'];


    $sql_update = "update " . $mysql_table_prefix . "salary_master set 
			to_date = now(),
			InsertDate = now(),
			IpAddress = '$ip'
			where emp_id = '$emp_id'";

    $result_check = mysql_query($sql_update) or die("Query Failed " . mysql_error());

    $sql_insert_salary = "insert into " . $mysql_table_prefix . "salary_master set emp_id = '$emp_id',"
            . "basic = '$basic',leave_travel_allow = '$lta',hra = '$hra',side_allowance = '$side_allowance',"
            . "convence = '$convence',tds = '$tds',other_deductions = '$other_gain',medical = '$medical',"
            . "professional_tax = '$p_tax',from_date = now(),InsertBy = '',InsertDate = now(),IpAddress = ''";

    $result_check = mysql_query($sql_insert_salary) or die("Query Failed " . mysql_error());
}

//////////// *************** Delete Empolyee ************** ///////////////
if (isset($_POST["btn_del"])) {
    $rec_id = $_POST["hidden_overlay"];

    $sql = "delete from " . $mysql_table_prefix . "account_detail where emp_id = '" . $rec_id . "'";
    mysql_query($sql) or die("Invalid query : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());

    $sql = "delete from " . $mysql_table_prefix . "attendence_master where emp_id = '" . $rec_id . "'";
    mysql_query($sql) or die("Invalid query : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());

    $sql = "delete from " . $mysql_table_prefix . "department_employee where emp_id = '" . $rec_id . "'";
    mysql_query($sql) or die("Invalid query : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());

    $sql = "delete from " . $mysql_table_prefix . "designation_employee where emp_id = '" . $rec_id . "'";
    mysql_query($sql) or die("Invalid query : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());

    $sql = "delete from " . $mysql_table_prefix . "education_master where emp_id = '" . $rec_id . "'";
    mysql_query($sql) or die("Invalid query : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());

    $sql = "delete from " . $mysql_table_prefix . "family_master where emp_id = '" . $rec_id . "'";
    mysql_query($sql) or die("Invalid query : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());

    $sql = "delete from " . $mysql_table_prefix . "good_work_master where emp_id = '" . $rec_id . "'";
    mysql_query($sql) or die("Invalid query : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());

    $sql = "delete from " . $mysql_table_prefix . "leave_application where emp_id = '" . $rec_id . "'";
    mysql_query($sql) or die("Invalid query : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());

    $sql = "SELECT rec_id FROM mpc_loan_employee where emp_id = '$rec_id'";
    //echo $sql;
    $result = mysql_query($sql) or die("Error in : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());

    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {

            $sql = "delete from " . $mysql_table_prefix . "loan_installments where loan_id = '" . $row['rec_id'] . "'";
            mysql_query($sql) or die("Invalid query : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());
        }
    }

    $sql = "delete from " . $mysql_table_prefix . "loan_employee where emp_id = '" . $rec_id . "'";
    mysql_query($sql) or die("Invalid query : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());

    $sql = "delete from " . $mysql_table_prefix . "official_detail where emp_id = '" . $rec_id . "'";
    mysql_query($sql) or die("Invalid query : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());


    $sql = "delete from " . $mysql_table_prefix . "plant_employee where emp_id = '" . $rec_id . "'";
    mysql_query($sql) or die("Invalid query : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());

    $sql = "delete from " . $mysql_table_prefix . "rotation_type_employee where emp_id = '" . $rec_id . "'";
    mysql_query($sql) or die("Invalid query : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());

    $sql = "delete from " . $mysql_table_prefix . "salary_master where emp_id = '" . $rec_id . "'";
    mysql_query($sql) or die("Invalid query : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());

    $sql = "delete from " . $mysql_table_prefix . "shift_detail where emp_id = '" . $rec_id . "'";
    mysql_query($sql) or die("Invalid query : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());

    $sql = "delete from " . $mysql_table_prefix . "weekly_off_employee where emp_id = '" . $rec_id . "'";
    mysql_query($sql) or die("Invalid query : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());

    $employee_picture = getemployeeDetail('employee_picture', $rec_id);
    if ($employee_picture != "") {
        unlink("employee_picture/thumb/$employee_picture");
        unlink("employee_picture/$employee_picture");
    }
    $sql = "delete from " . $mysql_table_prefix . "employee_master where rec_id = '" . $rec_id . "'";
    mysql_query($sql) or die("Invalid query : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());

    $msg = "Employee Sucessfully Deleted";
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
?>
<script language="javascript1.2">
    function edit_div(div_id, value)
    {
        var id = div_id;
        document.getElementById(id).innerHTML = value;
    }
</script>
<script language="javascript1.2">
    function edit_two_div(div_id1, value1, value2, value3)
    {
        document.getElementById(div_id1).innerHTML = value1;
        document.getElementById(div_id2).innerHTML = value2;
        document.getElementById(div_id3).innerHTML = value3;
    }
</script>
<script language="javascript1.2">
    function sum_salary()
    {
        var total_earning = 0;
        var a1 = 0;
        var a2 = 0;
        var a3 = 0;
        var a4 = 0;
        var a5 = 0;
        var a6 = 0;

        a1 = document.getElementById('salary_basic').value;
        a2 = document.getElementById('salary_lta').value;
        a3 = document.getElementById('salary_hra').value;
        a4 = document.getElementById('side_allowance').value;
        a5 = document.getElementById('convence').value;
        a6 = document.getElementById('medical').value;

        var a7 = document.getElementById('professional_tax').value;
        var a8 = document.getElementById('tds').value;
        var a9 = document.getElementById('other_deduction').value;

        var a10 = document.getElementById('pf_rate').value;
        var a11 = document.getElementById('esi_rate').value;
        var a12 = document.getElementById('cellin_val').value;


        total_earning = parseInt(a1) + parseInt(a2) + parseInt(a3) + parseInt(a4) + parseInt(a5) + parseInt(a6);
        a10 = a10.replace('%', '');

        if (a12 == 'yes') {
            var pf = (a10 * 6500) / 100;
        }
        else {
            var pf = (a10 * a1) / 100;
        }
        //var pf=(a10*a1)/100;
        var esi = (a11 * total_earning) / 100;

        document.getElementById('total_earning').value = total_earning;
        document.getElementById('total_earning').value = total_earning;

        document.getElementById('pf_value').value = pf;
        document.getElementById('esi_value').value = esi;

        var total_deduction = parseInt(a7) + parseInt(a8) + parseInt(a9) + pf + esi;
        document.getElementById('total_deduction').value = total_deduction;


        //var a =document.getElementById(salary_basic).value=value1;
        //var a =document.getElementById(div_id2).value=value2;
    }
</script>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0" bgcolor="#FFFFFF">
    <tr>
        <td align="left" valign="top" width="230px" style="padding-top:5px;">
            <? include ("inc/snb.php"); ?>
        </td>

        <td style="padding-left:5px; padding-top:5px;" valign="top">
            <table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
                <tr>
                    <td align="center" class="gray_bg" >&nbsp; <a href="#" style="text-decoration:none;color:gray;">Employee master -> </a>employee List</td>
                </tr>
                <tr>
                    <td class="red" align="center"><?= $msg ?></td>
                </tr>
                <tr>
                    <td valign="top">
                        <table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
                            <tr>
                                <td valign="top">
                                    <? include("list_employee_ajax.php"); ?>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<div id="overlay">
    <div>
        <p class="form_msg">Are you sure to delete this Employee</p>
        <form name="frm_del" action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
            <input type="hidden" name="hidden_overlay" id="hidden_overlay" value="" />
            <input type="submit" class="btn_bg1" name="btn_del" id="btn_del" value="Yes" />
            <input type="button" class="btn_bg1" onClick="overlay();" name="btn_close" value="No" />
        </form>
    </div>
</div>
<DIV id=modal style="DISPLAY: none;">
    <div style="padding: 0px; background-color: rgb(37, 100, 192); visibility: visible; position: relative; width: 222px; height: 202px; z-index: 10002; opacity: 1;">
        <div onClick="Popup.hide('modal')" style="padding: 0px; background: transparent url(./images/close.gif) no-repeat scroll 0%; visibility: visible; position: absolute; left: 201px; top: 1px; width: 20px; height: 20px; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial; cursor: pointer; z-index: 10004;" id="adpModal_close"></div>
        <div style="padding: 0px; background: transparent url(resize.gif) no-repeat scroll 0%; visibility: visible; position: absolute; width: 9px; height: 9px; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial; cursor: nw-resize; z-index: 10003;" id="adpModal_rsize"></div>
        <div style="padding: 0px; overflow: hidden; background-color: rgb(140, 183, 231); visibility: visible; position: absolute; left: 1px; top: 1px; width: 220px; height: 20px; font-family: arial; font-style: normal; font-variant: normal; font-weight: bold; font-size: 9pt; line-height: normal; font-size-adjust: none; font-stretch: normal; color: rgb(15, 15, 15); cursor: move;" id="adpModal_adpT"></div>
        <div style="border-style: inset; border-width: 0px; padding: 8px; overflow: hidden; background-color: rgb(118, 201, 238); visibility: visible; position: absolute; left: 1px; top: 21px; width: 204px; height: 164px; font-family: MS Sans Serif; font-style: normal; font-variant: normal; font-weight: bold; font-size: 11pt; line-height: normal; font-size-adjust: none; font-stretch: normal; color: rgb(28, 94, 162);" id="adpModal_adpC">
            <center>
                <p>
                <div id="div_message"></div>
                </p>
                <p style="font-size: 10px; color: rgb(253, 80, 0);">To gain access to the page behind the popup must be closed</p>
            </center>
        </div>
    </div>
</DIV>   
<iframe width=168 height=190 name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="calendar/ipopeng.htm" scrolling="no" frameborder="0" style="border:2px ridge; visibility:visible; z-index:5000; position:absolute; left:-500px; top:0px;">
</iframe> 
<? include ("inc/hr_footer.php"); ?>	

