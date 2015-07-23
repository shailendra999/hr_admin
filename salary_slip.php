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
//my cdoe//
$_POST["employee_type"];
$_POST["ticket_id"];
$_POST["department"];
$_POST["sub_department"];
$_POST["plant_name"];
if (isset($_POST["employee_type"]) and isset($_POST["ticket_id"]) and isset($_POST["department"]) and isset($_POST["sub_department"])
        and isset($_POST["plant_name"])) {

    if (($_POST["employee_type"] != "")) {
        $select_string = ",mpc_designation_employee.*,mpc_designation_master.*";
        $employee_type = $_POST["employee_type"];
        $table_list = ",mpc_designation_employee,mpc_designation_master";
        $where_string.=" and mpc_designation_employee.emp_id =mpc_employee_master.emp_id and mpc_designation_employee.designation_id=mpc_designation_master.rec_id and mpc_designation_master.emp_category='$employee_type' and mpc_designation_employee.to_date='0000-00-00'";
    }


    if ($_POST["ticket_id"] != "") {
        $select_string = "";
        $ticket_id = $_POST["ticket_id"];
        $table_list.= "";
        $where_string.="and mpc_employee_master.ticket_no ='$ticket_id'";
    }
    if ($_POST["department"] != "" and $_POST["sub_department"] == "") {
        $select_string = ",mpc_department_employee.*,mpc_department_master.*";
        $department = $_POST["department"];
        $table_list.= ",mpc_department_employee,mpc_department_master";

        $where_string.=" and mpc_department_employee.emp_id =mpc_employee_master.emp_id and mpc_department_master.reference_id ='$department' and mpc_department_employee.to_date='0000-00-00' and mpc_department_master.rec_id=mpc_department_employee.dept_id";
    }
    if ($_POST["sub_department"] != "") {
        $select_string = ",mpc_department_employee.*";
        $department = $_POST["department"];
        $sub_department = $_POST["sub_department"];
        $table_list.= ",mpc_department_employee";

        $where_string.="and mpc_department_employee.emp_id =mpc_employee_master.emp_id and mpc_department_employee.dept_id ='$sub_department' and mpc_department_employee.to_date='0000-00-00'";
    }
    if ($_POST["plant_name"] != "") {
        $select_string = ",mpc_plant_employee.*";
        $plant_name = $_POST["plant_name"];
        $table_list.= ",mpc_plant_employee";

        $where_string.=" and mpc_plant_employee.emp_id =mpc_employee_master.emp_id and mpc_plant_employee.plant_id ='$plant_name' and mpc_plant_employee.to_date='0000-00-00'";
    }
}

if (isset($_POST["btn_submit_x"]) or isset($_GET['month'])) {
    if (isset($_POST["ticket_id"])) {
        $sql_prj = "select DAY(mpc_official_detail.date_joining) as 'Day',MONTH(mpc_official_detail.date_joining) as 'Month' ,YEAR(mpc_official_detail.date_joining) as 'Year',mpc_official_detail.date_joining,mpc_employee_master.rec_id as id,mpc_employee_master.ticket_no,mpc_employee_master.first_name,mpc_employee_master.last_name,mpc_official_detail.emp_id ,mpc_account_detail.emp_id,mpc_account_detail.date_releaving $select_string from " . $mysql_table_prefix . "employee_master,mpc_official_detail,mpc_account_detail $table_list where mpc_employee_master.emp_id!='' and mpc_employee_master.emp_id=mpc_official_detail.emp_id and EXTRACT(YEAR_MONTH FROM mpc_official_detail.date_joining)<='$year$month' and mpc_employee_master.emp_id=mpc_account_detail.emp_id and mpc_account_detail.date_releaving ='0000-00-00' AND mpc_employee_master.ticket_no = '$_POST[ticket_id]'";
    } if (empty($_POST["ticket_id"])) {
       $sql_prj = "select DAY(mpc_official_detail.date_joining) as 'Day',MONTH(mpc_official_detail.date_joining) as 'Month' ,YEAR(mpc_official_detail.date_joining) as 'Year',mpc_official_detail.date_joining,mpc_employee_master.rec_id as id,mpc_employee_master.ticket_no,mpc_employee_master.first_name,mpc_employee_master.last_name,mpc_official_detail.emp_id ,mpc_account_detail.emp_id,mpc_account_detail.date_releaving $select_string from " . $mysql_table_prefix . "employee_master,mpc_official_detail,mpc_account_detail $table_list where mpc_employee_master.emp_id!='' and mpc_employee_master.emp_id=mpc_official_detail.emp_id and mpc_employee_master.emp_id=mpc_account_detail.emp_id and mpc_account_detail.date_releaving ='0000-00-00' $where_string ORDER BY ticket_no";
    }


    $query_count = "select count(*) as count from " . $mysql_table_prefix . "employee_master";

    $result_prj = mysql_query($sql_prj) or die("Error in Query :" . $sql_prj . "<br>" . mysql_error() . ":" . mysql_errno());

    $query_count = $query_count;
    $result = mysql_query($query_count);
    $row_count = mysql_fetch_array($result);
    $numrows = $row_count['count'];
    $count = ceil($numrows / $row_limit);
}
?>
<style>
    select{height:36px !important; width:185px !important;}
</style>
<script LANGUAGE="JavaScript">
    function marcarTodos() {
        if (document.frm_chech_emp.master.checked == true)
        {
            for (i = 0; i < document.frm_chech_emp.elements.length; i++)
            {
                if (document.frm_chech_emp.elements[i].type == 'checkbox')
                {
                    document.frm_chech_emp.elements[i].checked = true;
                }
            }
        }
        else {
            for (i = 0; i < document.frm_chech_emp.elements.length; i++)
            {
                if (document.frm_chech_emp.elements[i].type == 'checkbox')
                {
                    document.frm_chech_emp.elements[i].checked = false
                }
            }
        }
    }
</script>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
    <tr>
        <td align="left" valign="top" width="230px" style="padding-top:5px;">
            <? include ("inc/snb.php"); ?>
        </td>       
        <td style="padding-left:5px; padding-top:5px;" valign="top">
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
                                                                    <!--tr>
                                                                        <td class="text_1" colspan="2">
                                                                            <b>Filter By:</b>
                                                                        </td>
                                                                    </tr>
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
                                                                            <b>Emp ID</b>
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" name="ticket_id" id="ticket_id" value="<?= $ticket_id ?>" size="4" width="13%"/>
                                                                        </td>
                                                                    </tr-->
                                                                    <!--tr>
                                                                        <td class="text_1">
                                                                            <b>Department</b>
                                                                        </td>
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
                                                                            <b>Sub Department</b>
                                                                        </td>
                                                                        <td>
                                                                            <div id="div_sub_dept">

                                                                                <select name="sub_department" id="sub_department" style="width:150px; height:25px;" onchange="">
                                                                                    <option value="<?php echo $sub_department ?>">Select</option>

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
                                                                    </tr--> 
                                                                    <tr>
                                                                        <td colspan="6" align="center" style="padding-top:5px;">
                                                                            <input name="no_refresh" type="hidden" id="no_refresh" value="<?php echo uniqid(rand()); ?>" />
                                                                            <input type="image" src="images/btn_view.jpg" name="btn_submit" id="btn_submit" value="View"/>

                                                                            <a href="javascript:;" onclick="document.location = 'salary_slip.php';">
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
                                                    if (isset($_POST["btn_submit_x"]) or isset($_POST['month']))
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
                                                                                        <td width="15%" align="left"><input type="checkbox" name="master" onClick="marcarTodos()"><b>Name</b></td>
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
<iframe width=168 height=190 name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="calendar/ipopeng.htm" scrolling="no" frameborder="0" style="border:2px ridge; visibility:visible; z-index:999; position:absolute; left:-500px; top:0px;">
</iframe> 
<script type="text/javascript" src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
<script>
                                                                                    $("#print_card").click(function () {

                                                                                        if ($('input[type=checkbox]:checked').length == 0) {

                                                                                            alert("Please select minimum one checkbox");
                                                                                            return false;

                                                                                        }

                                                                                    })
</script>
<script>
    $("#print_card_xls").click(function () {

        if ($('input[type=checkbox]:checked').length == 0) {

            alert("Please select minimum one checkbox");
            return false;

        }

    })
</script>

<script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>


<? include ("inc/hr_footer.php"); ?>	