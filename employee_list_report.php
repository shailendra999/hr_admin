<? include ("inc/hr_header.php"); ?>
<!--<link rel="stylesheet" href="css/BeatPicker.min.css"/>
<script src="js/jquery-1.11.0.min.js"></script>
<script src="js/BeatPicker.min.js"></script>-->
<script>
    $(function () {
        //$( "#dob" ).datepicker();
        $('.footer').hide();
    });
</script>
<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
<?
$date = "";
$employee_type = "";
$department = "";
?>
<style>
    select,input[type="text"]{height:31px !important; width:185px !important;margin: 0 8px 0 0;}
</style>

<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
    <tr>
        <td align="left" valign="top" width="230px" style="padding-top:5px;"><? include ("inc/snb.php"); ?></td>
        <td style="padding-left:5px; padding-top:5px;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
                <tr>
                    <td align="center" class="gray_bg">&nbsp; <a href="#" style="text-decoration:none;color:gray;">Report-> </a>employee list</td>
                </tr>
                <tr>
                    <td class="heading" valign="top" style="padding-top:5px;"><table align="center" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-top:5px;" bgcolor="#f3fbd2">
                            <tr>
                                <td style="padding-top:10px;" align="center">
                                    <form name="frm_date" id="frm_date" method="post">
                                        <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
                                            <tr>
                                                <td align="left" class="text_1">Date</td>
                                                <td align="left"><input type="text" name="txt_date" id="txt_date" value="<?= $date ?>" style="width:80px; height:20px;" data-beatpicker="true"/></td>
                                            </tr>
                                            <tr>
                                                <td class="text_1"> Emp Type</td>
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
                                                    </select></td>
                                            </tr>
                                            <tr>
                                                <td class="text_1"> Department</td>
                                                <td>
                                                    <?
                                                    $sql = "SELECT * FROM mpc_department_master where reference_id='0' order by department_name";
                                                    $result = mysql_query($sql) or die("Error in sql : " . $sql . " : " . mysql_errno() . " : " . mysql_error());
                                                    ?>
                                                    <select name="department" id="department" style="width:150px; height:20px;" onChange="get_frm('get_department.php', this.value, 'div_sub_dept', 'sub_department');">
                                                        <option value="">Select</option>
                                                        <?
                                                        while ($row = mysql_fetch_array($result)) {
                                                            ?>
                                                            <option value="<?= $row['rec_id'] ?>" <? if ($row['rec_id'] == $department) { ?> selected="selected" <? } ?>>
                                                                <?= $row["department_name"] ?>
                                                            </option>
                                                        <? } ?>
                                                    </select></td>
                                            </tr>
                                            <tr>
                                                <td class="text_1"> Sub</td>
                                                <td>
                                                    <div id="div_sub_dept" style="display:inline;">
                                                        <?
                                                        $sql = "SELECT * FROM  mpc_department_master where reference_id = '$department' order by department_name";
                                                        $result_city = mysql_query($sql) or die("Error in : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());
                                                        ?>
                                                        <select name="sub_department" id="sub_department" style="width:150px; height:20px;">
                                                            <option value="">--Select--</option>
                                                            <?
                                                            if (mysql_num_rows($result_city) > 0) {
                                                                while ($row_city = mysql_fetch_array($result_city)) {
                                                                    ?>
                                                                    <option value="<?= $row_city['rec_id'] ?>" <? if ($row_city['rec_id'] == $sub_department) { ?> selected="selected" <? } ?>>
                                                                        <?= $row_city['department_name'] ?>
                                                                    </option>
                                                                    <?
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div></td>

                                            </tr>
                                            <tr>
                                                <td colspan="8" align="center" style="padding-top:5px;">
                                                    <input name="no_refresh" class="btn_bg" type="hidden" id="no_refresh" value="<?php echo uniqid(rand()); ?>" />
                                                    <input type="submit" name="view_list" id="view_list" value="View" class="btn_bg"/>
                                                    <a href="employee_list_report_excel.php" class="btn_bg">Export To Xls</a></td>
                                            </tr>
                                        </table>
                                    </form>
                                    <?php
                                    if (isset($_POST['view_list'])) {
                                        include ("inc/dbconnection.php");

                                        $date = $_POST['txt_date'];
                                        $db_date = getdbDate($date);
                                        $where_string_sub_department = "";

                                        if ($_POST["department"] != "") {
                                            $department = $_POST["department"];
                                            $where_string_department = " rec_id ='$department'";
                                        } else {
                                            $where_string_department = " reference_id='0'";
                                        }
                                        if ($_POST["sub_department"] != "" and $_POST["department"] != "") {
                                            $sub_department = $_POST["sub_department"];
                                            $where_string_sub_department = "and rec_id ='$sub_department'";
                                        }

                                        if ((isset($_POST["employee_type"]) != "")) {
                                            $select_string = ",mpc_designation_employee.*,mpc_designation_master.*";
                                            $employee_type = $_POST["employee_type"];
                                            $table_list = ",mpc_designation_employee,mpc_designation_master";
//                                            $where_string = "and mpc_designation_employee.emp_id = mpc_department_employee.emp_id and mpc_designation_employee.designation_id=mpc_designation_master.rec_id and mpc_designation_master.emp_category='$employee_type' and mpc_designation_employee.to_date='0000-00-00'";
                                        }
                                        ?>
                                        <table width="100%" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td> List  of  Employee(STAFF/SEMI-STAFF/WORKERS):
                                                    <?= $date ?></td>
                                            </tr>
                                            <tr>
                                                <td colspan="1"><table width="100%">
                                                        <tr>
                                                            <td width="10%"> SNO </td>
                                                            <td width="25%"> EMPLOYEE ID </td>
                                                            <td width="35%"> NAME </td>
                                                            <td width="35%"> Designation </td>
                                                            <td> Date Of Joining </td>
                                                        </tr>
                                                        <?
//                                                        echo $sql_prj = "select * from " . $mysql_table_prefix . "department_master where $where_string_department";
                                                        $sql_prj = "select * from " . $mysql_table_prefix . "department_master ";
                                                        $result_prj = mysql_query($sql_prj) or die("Error in Query :" . $sql_prj . "<br>" . mysql_error() . ":" . mysql_errno());
                                                        if (mysql_num_rows($result_prj) > 0) {
                                                            while ($row = mysql_fetch_array($result_prj)) {
                                                                $sql_sub = "select * from " . $mysql_table_prefix . "department_master where reference_id='" . $row['rec_id'] . "' $where_string_sub_department";
                                                                $result_sub = mysql_query($sql_sub) or die("Error in Query :" . $sql_sub . "<br>" . mysql_error() . ":" . mysql_errno());
                                                                if (mysql_num_rows($result_prj) > 0) {
                                                                    while ($row_sub = mysql_fetch_array($result_sub)) {
                                                                        ?>
                                                                        <tr>
                                                                            <td colspan="8" align="left"><?= $row['department_name'] ?>
                                                                                (<?= $row_sub['department_name'] ?>)
                                                                            </td>
                                                                        </tr>
                                                                        <?
//                                                                        echo $sql_emp = "select * $select_string from " . $mysql_table_prefix . "employee_master,mpc_department_employee,mpc_official_detail,mpc_account_detail $table_list where mpc_official_detail.emp_id=mpc_employee_master.rec_id and mpc_account_detail.emp_id=mpc_employee_master.rec_id and mpc_employee_master.rec_id=mpc_department_employee.emp_id and mpc_department_employee.dept_id ='" . $row_sub['rec_id'] . "' and mpc_department_employee.to_date='0000-00-00' and mpc_account_detail.date_releaving ='0000-00-00' $where_string order by mpc_employee_master.ticket_no ASC";
                                                                        $sql_emp = "select * from mpc_employee_master,mpc_official_detail,mpc_account_detail ,mpc_department_master,mpc_designation_master where mpc_official_detail.emp_id=mpc_employee_master.rec_id and mpc_account_detail.emp_id=mpc_employee_master.rec_id  and mpc_employee_master.department ='" . $row_sub['rec_id'] . "' and mpc_account_detail.date_releaving ='0000-00-00' $where_string order by mpc_employee_master.ticket_no ASC";
                                                                        $result_emp = mysql_query($sql_emp) or die("Error in Query :" . $sql_emp . "<br>" . mysql_error() . ":" . mysql_errno());
                                                                        if (mysql_num_rows($result_emp) > 0) {
                                                                            $s = 1;
                                                                            while ($row_emp = mysql_fetch_array($result_emp)) {
                                                                                ?>
                                                                                <tr>
                                                                                    <td>
                                                                                        <?= $s ?>
                                                                                    </td>
                                                                                    <td>
                                                                                        <?= $row_emp['ticket_no'] ?>
                                                                                    </td>
                                                                                    <td>
                                                                                        <?= $row_emp['first_name'] . " " . $row_emp['last_name'] ?>
                                                                                    </td>
                                                                                    <td>
                                                                                        <?= getdesignationMaster('designation_name', 'rec_id', getdesignationDetail('designation_id', $row_emp['emp_id'], $db_date)) ?>
                                                                                    </td>
                                                                                    <td>
                                                                                        <?= getdbDate($row_emp['date_joining']) ?>
                                                                                    </td>
                                                                                </tr>
                                                                                <?
                                                                                $s++;
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }
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
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<!--<div id="view_list">this is for test</div>-->
<iframe width=168 height=190 name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="calendar/ipopeng.htm" scrolling="no" frameborder="0" style="border:2px ridge; visibility:visible; z-index:5000; position:absolute; left:-500px; top:0px;"> </iframe>
<? include ("inc/hr_footer.php"); ?>
<!--<script>

$(document).ready(function(){
 $("#view_list").click(function(){
  var emptype = $("#employee_type").val();
  var department = $("#department").val();
  var sub_department = $("#sub_department").val();
  var txt_date = $("#txt_date").val();
   $.ajax({   
                  url: "view_list_ajax.php?emptype="+emptype+'&depart='+department+'&sub_separt='+sub_department+'&txt_date='+txt_date, 
                  //The url where the server req would we made.  +'&depart='+department+'&sub_separt'+sub_department
                        async: false,
                        type: "GET", //The type which you want to use: GET/POST
                        dataType: "html", //Return data type (what we expect).
                        success: function(data) {
                                                $("#view_list").html(data);
                                                $("#view_list").show();
                                                }
                    });
  });
});
</script>-->