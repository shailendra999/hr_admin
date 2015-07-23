<?php
include("inc/user_header.php");
include("inc/dbconnection.php");
require_once ("inc/function.php");



/* _____________DELETE________________ */
/*
  if (isset($_POST["btn_delete"])) {

  $PageKeyValue = $_POST["hidden_overlay"];
  $Message = "Can Not Delete This Department Contain Sub department and dept alloted";
  if (checkDeptInDept($PageKeyValue) && checkDeptMaster($PageKeyValue)) {
  $sql = "delete from mpc_leave_application where rec_id = '" . $PageKeyValue . "'";
  mysql_query($sql) or die("Invalid query : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());
  $Message = "Department Sucessfully Deleted";
  }
  redirect("user_leave.php?Message=$Message");
  }
 */
$pgName = "";
$id = $_GET["id"];
$username = $_SESSION['user_mahima_session_user_name'];
$query_emp_master = mysql_query("select ticket_no,rec_id from mpc_employee_master where username='$username'");
$row_emp_master = mysql_fetch_array($query_emp_master);
$emp_ticket_no = $row_emp_master['ticket_no'];
$emp_rec_id = $row_emp_master['rec_id'];
$sql_emp_details = "SELECT mpc_employee_master.*,mpc_official_detail.emp_category,mpc_official_detail.emp_id,mpc_account_detail.emp_id,mpc_account_detail.date_releaving FROM mpc_employee_master,mpc_account_detail,mpc_official_detail where mpc_employee_master.rec_id=mpc_account_detail.emp_id and mpc_employee_master.rec_id=mpc_official_detail.emp_id and mpc_account_detail.date_releaving ='0000-00-00' and  ticket_no like '$emp_ticket_no' order by first_name";
$result_emp_details = mysql_query($sql_emp_details) or die("Error in : " . $sql_emp_details . "<br>" . mysql_errno() . " : " . mysql_error());
$row_emp_details = mysql_fetch_array($result_emp_details);
$emp_designation = $row_emp_details['designation'];

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
if (isset($_POST["btn_submit_x"]) or isset($_GET['month'])) {
//    if (isset($_POST["ticket_id"])) {
    $sql_prj = "select DAY(mpc_official_detail.date_joining) as 'Day',MONTH(mpc_official_detail.date_joining) as 'Month' ,YEAR(mpc_official_detail.date_joining) as 'Year',mpc_official_detail.date_joining,mpc_employee_master.rec_id as id,mpc_employee_master.ticket_no,mpc_employee_master.first_name,mpc_employee_master.last_name,mpc_official_detail.emp_id ,mpc_account_detail.emp_id,mpc_account_detail.date_releaving from mpc_employee_master,mpc_official_detail,mpc_account_detail $table_list where mpc_employee_master.emp_id!='' and mpc_employee_master.emp_id=mpc_official_detail.emp_id and EXTRACT(YEAR_MONTH FROM mpc_official_detail.date_joining)<='$year$month' and mpc_employee_master.emp_id=mpc_account_detail.emp_id and mpc_account_detail.date_releaving ='0000-00-00' AND mpc_employee_master.ticket_no = '$emp_ticket_no'";
//    }
//    if (empty($_POST["ticket_id"])) {
//        $sql_prj = "select DAY(mpc_official_detail.date_joining) as 'Day',MONTH(mpc_official_detail.date_joining) as 'Month' ,YEAR(mpc_official_detail.date_joining) as 'Year',mpc_official_detail.date_joining,mpc_employee_master.rec_id as id,mpc_employee_master.ticket_no,mpc_employee_master.first_name,mpc_employee_master.last_name,mpc_official_detail.emp_id ,mpc_account_detail.emp_id,mpc_account_detail.date_releaving $select_string from " . $mysql_table_prefix . "employee_master,mpc_official_detail,mpc_account_detail $table_list where mpc_employee_master.emp_id!='' and mpc_employee_master.emp_id=mpc_official_detail.emp_id and EXTRACT(YEAR_MONTH FROM mpc_official_detail.date_joining)<='$year$month' and mpc_employee_master.emp_id=mpc_account_detail.emp_id and mpc_account_detail.date_releaving ='0000-00-00' $where_string";
//    }


    $query_count = "select count(*) as count from " . $mysql_table_prefix . "employee_master";

    $result_prj = mysql_query($sql_prj) or die("Error in Query :" . $sql_prj . "<br>" . mysql_error() . ":" . mysql_errno());

    $query_count = $query_count;
    $result = mysql_query($query_count);
    $row_count = mysql_fetch_array($result);
    $numrows = $row_count['count'];
    $count = ceil($numrows / $row_limit);
}
?>
<div style="float:left" >
    <table width="20%" cellpadding="0" cellspacing="0" border="0" align="center">
        <tr>
            <td align="left" valign="top" width="230px" style="padding-top:5px;"><? include ("inc/snbuser.php"); ?></td>
        </tr>
    </table>
</div>
<table width="78%" cellpadding="0" cellspacing="0" align="center" border="0" >
    <tr>
        <td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/> &nbsp; Welcome to Laxyo Solution Soft Pvt. Ltd.</td>
    </tr>
    <tr>
        <td> 
            <table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
                <tr>
                    <td align="center" class="gray_bg">&nbsp; <a href="#" style="text-decoration:none;color:gray;">Salary master-> </a>salary slip</td>
                </tr>
                <tr>
                    <td height="500px" valign="top">
                        <table align="left" width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td>
                                    <table width="100%" cellpadding="0" cellspacing="0" align="left" border="0">
                                        <tr>
                                            <td class="red"><?= $msg ?></td>
                                        </tr>
                                        <tr>
                                            <td align="center" valign="top">
                                                <table align="left" width="100%" cellpadding="0" cellspacing="0" border="0" bgcolor="#f3fbd2" class="sSlip_tb" style=" margin-top:5px;">
                                                    <tr>
                                                        <td style="padding-top:10px;" align="center">
                                                            <form name="frm_month" id="frm_month" action="" method="post">
                                                                <table align="left" width="100%" cellpadding="0" cellspacing="0" border="0" style=" margin-left:20px;">
                                                                    <tr>
                                                                        <td colspan="8">
                                                                            <table align="left">
                                                                                <tr>                                                                  
                                                                                    <td align="left" class="text_1"><b>Year</b></td>
                                                                                    <td align="center">

                                                                                        <?
                                                                                        $sql_prd = "select max(date)as MAXDATE,min(date)as MINDATE from " . $mysql_table_prefix . "attendence_master ";
                                                                                        $result_prd = mysql_query($sql_prd) or die("Error in : " . $sql_prd . "<br>" . mysql_errno() . " : " . mysql_error());
                                                                                        $row_prd = mysql_fetch_array($result_prd);
                                                                                        $min_year = "2005";
                                                                                        $max_year = "20" . date("y") + 1;
                                                                                        ?>    
                                                                                        <select name="year" id="year" onchange="get_frm('get_month.php', this.value, 'div_month', '');" >
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
                                                                                </tr><tr>                                                                                                                                 <td align="left" class="text_1"><b>Month</b></td>
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
                                                                        <td colspan="6" align="center" style="padding-top:5px;">
                                                                            <input name="no_refresh" type="hidden" id="no_refresh" value="<?php echo uniqid(rand()); ?>" />
                                                                            <input type="image" src="images/btn_view.jpg" name="btn_submit" id="btn_submit" value="View"/>

                                                                            <a href="javascript:;" onclick="document.location = 'emp_slip_view.php';">
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
                                                <table align="center" width="100%" cellpadding="1" cellspacing="1" border="0" style="border:1px solid #CCCCCC;">
                                                    <?
                                                    if (isset($_POST["btn_submit"]) or isset($_POST['month']))
                                                        if (isset($_POST['month'])) {

                                                            if (mysql_num_rows($result_prj) > 0) {

                                                                $sno = $start + 1;
                                                                ?>
                                                                <tr>
                                                                    <td style="padding-top:10px" align="center">
                                                                        <form action="print_salary_slip.php" method="post" name="frm_chech_emp" id="frm_chech_emp" target="_blank">
                                                                            <div id="div_attandance_list" style="overflow:scroll;height:500px;width:1000px">
                                                                                <table align="center" width="100%" cellpadding="0" cellspacing="0" class="table1" border="1">
                                                                                    <tr class="gredBg">
                                                                                        <td width="5%" align="center"><b>Sno.</b></td>
                                                                                        <td width="5%" align="center"><b>Emp Id</b></td>
                                                                                        <td width="15%" align="left"><b>Name</b></td>
                                                                                    </tr>
                                                                                    <?
                                                                                    $sno = 1;
                                                                                    while ($row = mysql_fetch_array($result_prj)) {
                                                                                        $present = 0;
                                                                                        $absent = 0;
                                                                                        $Pl = 0;
                                                                                        $Cl = 0;
                                                                                        ?>	
                                                                                        <tr>
                                                                                            <td width="5%" align="center"><?= $sno ?></td>
                                                                                            <td width="5%" align="center"><?= $row['ticket_no'] ?></td>
                                                                                            <td width="15%" align="left"><input type="checkbox" name="emp_check[]" id="emp_check[]" value="<?= $row['id'] ?>"><?= $row['first_name'] ?> <?= $row['last_name'] ?></td>
                                                                                        </tr>
                                                                                        <?
                                                                                        $sno++;
                                                                                    }
                                                                                    ?>	
                                                                                    <tr>
                                                                                        <td align="center" colspan="3">

                                                                                            <input type="hidden" name="card_month" id="card_month" value="<?= $month ?>"/>
                                                                                            <input type="hidden" name="card_year" id="card_year" value="<?= $year ?>"/>
                                                                                            <input type="submit" name="print_card" id="print_card"  value="Print" onclick="return test()"/>
                                                                                            <input type="submit" name="print_card_xls" id="print_card_xls"  value="Export" onclick="return test()"/>
                                                                                        </td>
                                                                                    </tr> 													 
                                                                                </table>
                                                                            </div>   
                                                                        </form>                                                                   
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