<?php
include ("inc/hr_header.php");
?>
<script>
    $(function () {
        $('.footer').hide();
    });
</script>
<?php
$msg = '';
$plant = "";
$dep = "";
$dept_id = "";
$date_upto = isset($_POST['txt_date_to']) ? $_POST['txt_date_to'] : "";
$date_from = isset($_POST['txt_date_from']) ? $_POST['txt_date_from'] : "";
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

        $where_string.=" and mpc_department_employee.emp_id =mpc_employee_master.rec_id and mpc_department_master.reference_id ='$department' and mpc_department_employee.to_date='0000-00-00' and mpc_department_master.rec_id=mpc_department_employee.dept_id";
    }
    if ($_POST["sub_department"] != "") {
        $select_string = ",mpc_department_employee.*";
        $department = $_POST["department"];
        $sub_department = $_POST["sub_department"];
        $table_list.= ",mpc_department_employee";

        $where_string.=" and mpc_department_employee.emp_id =mpc_employee_master.rec_id and mpc_department_employee.dept_id ='$sub_department' and mpc_department_employee.to_date='0000-00-00'";
    }
    if ($_POST["plant_name"] != "") {
        $select_string = ",mpc_plant_employee.*";
        $plant_name = $_POST["plant_name"];
        $table_list.= ",mpc_plant_employee";
        $where_string.=" and mpc_plant_employee.emp_id =mpc_employee_master.rec_id and mpc_plant_employee.plant_id ='$plant_name' and mpc_plant_employee.to_date='0000-00-00'";
    }
}

if (isset($_POST["btn_submit_x"]) or isset($_GET['month'])) {
    $sql_prj = "select DAY(mpc_official_detail.date_joining) as 'Day',MONTH(mpc_official_detail.date_joining) as 'Month' ,YEAR(mpc_official_detail.date_joining) as 'Year',mpc_official_detail.date_joining,mpc_official_detail.employee_typ,mpc_employee_master.rec_id as id,mpc_employee_master.ticket_no,mpc_employee_master.first_name,mpc_employee_master.last_name,mpc_official_detail.emp_id,mpc_account_detail.emp_id,mpc_account_detail.date_releaving $select_string from " . $mysql_table_prefix . "employee_master,mpc_official_detail,mpc_account_detail $table_list where mpc_employee_master.rec_id!='' and mpc_employee_master.rec_id=mpc_official_detail.emp_id and mpc_official_detail.date_joining <='" . getdbDate($date_upto) . "' and mpc_employee_master.rec_id=mpc_account_detail.emp_id AND mpc_employee_master.first_name != '' and  mpc_account_detail.date_releaving ='0000-00-00' $where_string  order by ticket_no ASC";
    $result_prj = mysql_query($sql_prj) or die("Error in Query :" . $sql_prj . "<br>" . mysql_error() . ":" . mysql_errno());
}
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
                    <td align="center" class="gray_bg">&nbsp; <a href="#" style="text-decoration:none;color:gray;">Report-> </a>employee leave report</td>
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
                                                                <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
                                                                    <tr>
                                                                        <td colspan="8">
                                                                            <table align="left" width="100%">	
                                                                                <tr>
                                                                                    <td align="left" class="text_1" style="text-align:left;">
                                                                                        From Date: </td>
                                                                                    <td align="left">
                                                                                        <input type="text" name="txt_date_from" id="txt_date_from" style="width:100px; height:20px;" value="<?= $date_from ?>"  data-beatpicker="true"/>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td align="left" class="text_1" style="text-align:left;">
                                                                                        To Date: </td>
                                                                                    <td align="left">
                                                                                        <input type="text" name="txt_date_to" id="txt_date_to" style="width:100px; height:20px;" value="<?= $date_upto ?>"  data-beatpicker="true"/>
                                                                                    </td>
                                                                                </tr>
                                                                            </table>                                                               
                                                                        </td>
                                                                    </tr>
                                                                    <!--tr> 
                                                                        <td class="text_1" colspan="2">
                                                                            Filter By:                                                                 
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="text_1">
                                                                            Emp Type</td>
                                                                        <td>
                                                                            <select name="employee_type" id="employee_type">

                                                                                <option value="">---Select---</option>
                                                                    <?php
                                                                    $que = mysql_query("select type_name from mpc_employee_type_master");

                                                                    while ($row = mysql_fetch_array($que)) {
                                                                        ?>
                                                                                                                                                                                            <option value="<?php echo $row['type_name'] ?>"
                                                                        <?php
                                                                        if ($employee_type == $row['type_name']) {
                                                                            echo 'selected="selected"';
                                                                        }
                                                                        ?>>
                                                                        <?php echo $row['type_name']; ?> 
                                                                                                                                                                                            </option>
                                                                    <?php } ?>
                                                                            </select> 
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="text_1">
                                                                            Emp ID 
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" name="ticket_id" id="ticket_id" value="<?= $ticket_id ?>" size="4"/>                                                                    </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="text_1">
                                                                            Department
                                                                        </td>
                                                                        <td>
                                                                    <?
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
                                                                            Sub Department</td>
                                                                        <td>
                                                                            <div id="div_sub_dept">
                                                                                <select name="sub_department" id="sub_department" style="width:150px; height:25px;" onchange="">
                                                                                    <option value="">Select</option> 
                                                                                </select>
                                                                            </div>                                                                    </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="text_1">
                                                                            Plant</td>
                                                                        <td><?
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
                                                                            </select>                                                                    </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="text_1">
                                                                            OT</td>
                                                                        <td>
                                                                            <input type="checkbox" name="over_time" id="over_time"/>                                                                    </td>
                                                                    </tr--> 
                                                                    <tr>
                                                                        <td colspan="6" align="center" style="padding-top:5px;">
                                                                            <input name="no_refresh" type="hidden" id="no_refresh" value="<?php echo uniqid(rand()); ?>" />
                                                                            <input type="image" src="images/btn_view.jpg" name="btn_submit" id="btn_submit" value="View"/>
                                                                            <a href="javascript:;" onclick="document.location = 'salary_report_employee.php';"><img src="images/submit_button_Mahima.jpg" name="over" border="0"></a></td>
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
                                                            $sno = 1;
                                                            ?>
                                                            <tr>
                                                                <td align="right">
                                                                    <table cellpadding="0" cellspacing="0" border="0">
                                                                        <tr>
                                                                            <td>
                                                                                <form action="print_month_wise_salary_report.php" method="post" name="frm_print" id="frm_print" target="_blank">
                                                                                    <input type="hidden" name="txt_date_from" id="txt_date_from" value="<?= $_POST['txt_date_from'] ?>"/>
                                                                                    <input type="hidden" name="txt_date_to" id="txt_date_to" value="<?= $_POST['txt_date_to'] ?>"/>
                                                                                    <input type="hidden" name="print_employee_type" id="print_employee_type" value="<?= $employee_type ?>"/>
                                                                                    <input type="hidden" name="print_ticket_id" id="print_ticket_id" value="<?= $ticket_id ?>"/>
                                                                                    <input type="hidden" name="print_department" id="print_department" value="<?= $department ?>"/>
                                                                                    <input type="hidden" name="print_sub_department" id="print_sub_department" value="<?= $sub_department ?>"/>
                                                                                    <input type="hidden" name="print_plant_name" id="print_plant_name" value="<?= $plant_name ?>"/>
                                                                                    <input type="image" src="images/btn_print.jpg" name="btn_submit" id="btn_submit" value="View"/>
                                                                                </form>
                                                                            </td>
                                                                            <td valign="top">
                                                                                <form action="month_wise_salary_report_excel.php" method="post" name="frm_print_xls" id="frm_print_xls" target="_blank" style="display:inline;">
                                                                                    <input type="hidden" name="txt_date_from" id="txt_date_from" value="<?= $_POST['txt_date_from'] ?>"/>
                                                                                    <input type="hidden" name="txt_date_to" id="txt_date_to" value="<?= $_POST['txt_date_to'] ?>"/>
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
                                                                                <td width="5%" align="center" rowspan="2"><b>S.No.</b></td>
                                                                                <td align="center" rowspan="2"><b>Emp Id</b></td>
                                                                                <td align="center" rowspan="2"><b>Employee Name<br/></b></td>
                                                                                <td align="center" rowspan="2"><b>Department</b></td>
                                                                                <td align="center" rowspan="2"><b>Date Of Joining</b></td>
                                                                                <td align="center" colspan="3"><b>Record Of Leave</b></td>
                                                                            </tr>
                                                                            <tr class="gredBg">
                                                                                <?php
                                                                                $leave_select = mysql_query("select * from mpc_leave_master");
                                                                                while ($fetch_leave = mysql_fetch_array($leave_select)) {
                                                                                    ?>
                                                                                    <td align="center"><b>Total <?= $fetch_leave['leave_name'] ?></b></td>
                                                                                    <td align="center"><b>Available <?= $fetch_leave['leave_name'] ?></b></td>
                                                                                    <td align="center"><b>Balance <?= $fetch_leave['leave_name'] ?></b></td>
                                                                                <? } ?>
                                                                            </tr>
                                                                            <?
                                                                            while ($row = mysql_fetch_array($result_prj)) {
                                                                                $start_date = "01";
                                                                                $emp_id = $row['id'];
//                                                                                echo "select * from mpc_leave_application where emp_id = '$emp_id'";
                                                                                $leave_app = mysql_query("select * from mpc_leave_application where emp_id = '$emp_id'");

                                                                                $start_date = getdbDateSepretoe($_POST['txt_date_from']);

                                                                                $end_date = getdbDateSepretoe($_POST['txt_date_to']);

                                                                                $day1 = substr($_POST['txt_date_from'], 0, 2);
                                                                                $month1 = substr($_POST['txt_date_from'], 3, 2);
                                                                                $year1 = substr($_POST['txt_date_from'], 6, 4);

                                                                                $day2 = substr($_POST['txt_date_to'], 0, 2);
                                                                                $month2 = substr($_POST['txt_date_to'], 3, 2);
                                                                                $year2 = substr($_POST['txt_date_to'], 6, 4);

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
                                                                                    $flag = 0;
                                                                                    $i++;
                                                                                }
                                                                                ?>
                                                                                <tr <? if ($sno % 2 == 1) { ?> bgcolor="#F8F8F8" <? } ?> class="tableTxt">
                                                                                    <td align="center"><?= $sno ?></td>
                                                                                    <td align="center"><?= $row['ticket_no'] ?></td>
                                                                                    <td align="center">
                                                                                        <?= $row['first_name'] ?> <?= $row['last_name'] ?><br/>
                                                                                    </td>
                                                                                    <td width="15%" align="center">
                                                                                        <?= getdeptDetail('department_name', 'rec_id', getdepartmentDetail('dept_id', $emp_id, getdbDate($date_from))); ?>
                                                                                    </td>
                                                                                    <td><?= getDatetime(getofficeDetail('date_joining', $emp_id)) ?></td>
                                                                                    <?php
                                                                                    $leave_select = mysql_query("select * from mpc_leave_master");
                                                                                    while ($fetch_leave = mysql_fetch_array($leave_select)) {
                                                                                        ?>
                                                                                        <td>

                                                                                        </td>
                                                                                        <?
                                                                                        while ($fetch_lea = mysql_fetch_array($leave_app)) {
                                                                                            if ($fetch_lea['leave_type'] == $fetch_leave['rec_id']) {
                                                                                                ?>
                                                                                                <td>
                                                                                                    <?= $fetch_lea['days'] ?>
                                                                                                </td>
                                                                                                <?php
                                                                                            } else {
                                                                                                ?>
                                                                                                <td>else</td>
                                                                                                <?
                                                                                            }
                                                                                        }
                                                                                        ?>
                                                                                        <td>

                                                                                        </td>
                                                                                        <?
                                                                                    }
                                                                                    ?>
                                                                                </tr>
                                                                                <?
                                                                                $sno++;
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