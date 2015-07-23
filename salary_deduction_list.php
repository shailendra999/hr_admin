<?php
include ("inc/hr_header.php");

$msg = '';
$plant = "";
$dep = "";
$dept_id = "";
?>
<script>
    function overlay(id) {
        el = document.getElementById("overlay");
        document.getElementById("hidden_overlay").value = id;
        el.style.visibility = (el.style.visibility == "visible") ? "hidden" : "visible";

    }
</script>
<?
//////////// *************** Delete Advance ************** ///////////////

if (isset($_POST["btn_del"])) {
    $rec_id = $_POST["hidden_overlay"];
    $sql = "delete from mpc_salary_deduction where rec_id = '" . $rec_id . "'";
    mysql_query($sql) or die("Invalid query : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());
    $msg = "Salary Deduction Sucessfully Deleted";
}
//////******************** Edit Dedution **************///////
if (isset($_POST['salary_ded_id'])) {
    $salary_ded_id = $_POST["salary_ded_id"];
    $txt_fine = $_POST["txt_fine"];
    $txt_damage = $_POST["txt_damage"];
    $txt_canteen = $_POST["txt_canteen"];
    $txt_society_welfare = $_POST["txt_society_welfare"];
    $txt_elecrical = $_POST["txt_elecrical"];
    $txt_security = $_POST["txt_security"];
    $txt_house_rent = $_POST["txt_house_rent"];
    $txt_date = getdbDateSepretoe($_POST["txt_date"]);

    $sql_up = "update mpc_salary_deduction set salary_fine = '$txt_fine',salary_damage  = '$txt_damage',
	salary_canteen 	 = '$txt_canteen',salary_society_welfare = '$txt_society_welfare',
	salary_electrical = '$txt_elecrical',salarly_security = '$txt_security',salarly_security = '$txt_security',
      	salary_house_rent = '$txt_house_rent',salary_deduction_date = '$txt_date'where rec_id= '$salary_ded_id'";

    //echo $sql_up;
    $result_up = mysql_query($sql_up) or die("Query Failed " . mysql_error());
    if ($result_up) {
        $msg = "Salary Deduction Updated!!";
    } else {
        $msg = "Error In Updating Salary Deduction!!";
    }
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
if (isset($_POST["employee_type"]) and isset($_POST["ticket_id"]) and isset($_POST["department"]) and isset($_POST["sub_department"])
        and isset($_POST["plant_name"])) {
    if (($_POST["employee_type"] != "")) {
        $select_string = ",mpc_designation_employee.*,mpc_designation_master.*";
        $employee_type = $_POST["employee_type"];
        $table_list = ",mpc_designation_employee,mpc_designation_master";
        $where_string.="and mpc_designation_employee.emp_id =mpc_employee_master.rec_id and mpc_designation_employee.designation_id=mpc_designation_master.rec_id and mpc_designation_master.emp_category='$employee_type' and mpc_designation_employee.to_date='0000-00-00'";
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

        $where_string.="and mpc_department_employee.emp_id =mpc_employee_master.rec_id and mpc_department_master.reference_id ='$department' and mpc_department_employee.to_date='0000-00-00' and mpc_department_master.rec_id=mpc_department_employee.dept_id";
    }
    if ($_POST["sub_department"] != "") {
        $select_string = ",mpc_department_employee.*";
        $department = $_POST["department"];
        $sub_department = $_POST["sub_department"];
        $table_list.= ",mpc_department_employee";

        $where_string.="and mpc_department_employee.emp_id =mpc_employee_master.rec_id and mpc_department_employee.dept_id ='$sub_department' and mpc_department_employee.to_date='0000-00-00'";
    }
    if ($_POST["plant_name"] != "") {
        $select_string = ",mpc_plant_employee.*";
        $plant_name = $_POST["plant_name"];
        $table_list.= ",mpc_plant_employee";
    }
}
if (isset($_POST["btn_submit_x"]) or isset($_GET['month'])) {
    $sql_prj = "select DAY(mpc_official_detail.date_joining) as 'Day',MONTH(mpc_official_detail.date_joining) as 'Month' ,YEAR(mpc_official_detail.date_joining) as 'Year',mpc_official_detail.date_joining,mpc_employee_master.rec_id as id,mpc_employee_master.ticket_no,mpc_employee_master.first_name,mpc_employee_master.last_name,mpc_official_detail.emp_id ,mpc_account_detail.emp_id,mpc_account_detail.date_releaving,mpc_salary_deduction.salary_fine,mpc_salary_deduction.salary_damage,mpc_salary_deduction.salary_canteen,mpc_salary_deduction.salary_society_welfare,mpc_salary_deduction.salary_electrical,mpc_salary_deduction.salarly_security,mpc_salary_deduction.salary_house_rent,mpc_salary_deduction.salary_deduction_date,mpc_salary_deduction.rec_id as salary_ded_id $select_string from " . $mysql_table_prefix . "employee_master,mpc_official_detail,mpc_account_detail,mpc_salary_deduction $table_list where mpc_employee_master.rec_id !='' and mpc_employee_master.emp_id=mpc_official_detail.emp_id and EXTRACT(YEAR_MONTH FROM mpc_official_detail.date_joining)<='$year$month' and mpc_employee_master.emp_id=mpc_account_detail.emp_id and mpc_account_detail.date_releaving ='0000-00-00' and mpc_salary_deduction.emp_id = mpc_employee_master.rec_id  $where_string  and  MONTH(mpc_salary_deduction.salary_deduction_date)='" . $month . "' and YEAR(mpc_salary_deduction.salary_deduction_date) ='" . $year . "' order by mpc_employee_master.ticket_no ASC";
    $result_prj = mysql_query($sql_prj) or die("Error in Query :" . $sql_prj . "<br>" . mysql_error() . ":" . mysql_errno());
}
?>
<style>
    select,input[type="text"]{height:36px !important; width:185px !important;margin:5px 0;}
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
                    <td align="center" class="gray_bg">&nbsp; <a href="#" style="text-decoration:none;color:gray;">Salary master-> </a>salary deduction list</td>
                </tr>
                <tr>
                    <td height="500px" valign="top">
                        <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td>
                                    <table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
                                        <tr>
                                            <td class="red"><?= $msg ?></td>
                                        </tr>
                                        <tr>
                                            <td align="center" valign="top">
                                                <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0" bgcolor="#f3fbd2" style=" margin-top:5px;">
                                                    <tr>
                                                        <td style="padding-top:10px;" align="center">
                                                            <form name="frm_month" id="frm_month" action="" method="post">
                                                                <table align="left" width="100%" cellpadding="0" cellspacing="0" border="0">
                                                                    <tr>
                                                                        <td colspan="8">
                                                                            <table align="left" style=" margin-left:20px;">
                                                                                <tr>                                                                  
                                                                                    <td align="center" class="text_1"><b>Year</b></td>
                                                                                    <td align="center">
                                                                                        <?
                                                                                        $sql_prd = "select max(date)as MAXDATE,min(date)as MINDATE from " . $mysql_table_prefix . "attendence_master ";
                                                                                        $result_prd = mysql_query($sql_prd) or die("Error in : " . $sql_prd . "<br>" . mysql_errno() . " : " . mysql_error());
                                                                                        $row_prd = mysql_fetch_array($result_prd);
                                                                                        $min_year = 2014;
                                                                                        $max_year = 2015;
                                                                                        ?>    
                                                                                        <select name="year" id="year" style="width:150px; height:25px;" onchange="get_frm('get_month.php', this.value, 'div_month', '');">
                                                                                            <option value="">--select--</option>

                                                                                            <?
                                                                                            for ($i = $min_year; $i <= 2015; $i++) {
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
                                                                                </tr>
                                                                                <tr>
                                                                                    <td align="left" class="text_1"><b>Month</b></td>
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
                                                                                <tr> 
                                                                                    <td class="text_1" colspan="2">
                                                                                        Filter By:
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="text_1">
                                                                                        Emp Type
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


                                                                                    <td class="text_1" align="left">
                                                                                        Emp ID 
                                                                                    </td>
                                                                                    <td align="left"><input type="text" name="ticket_id" id="ticket_id" value="<?= $ticket_id ?>" size="4"/>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="text_1">
                                                                                        Department
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
                                                                                        Sub Department
                                                                                    </td>
                                                                                    <td>
                                                                                        <div id="div_sub_dept">

                                                                                            <select name="sub_department" id="sub_department" style="width:150px; height:25px;" onchange="">
                                                                                                <option value="">Select</option>

                                                                                            </select>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="text_1">
                                                                                        Plant
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
                                                                                </tr>
                                                                                <tr>

                                                                                    <td colspan="6" align="center" style="padding-top:5px;">
                                                                                        <input name="no_refresh" type="hidden" id="no_refresh" value="<?php echo uniqid(rand()); ?>" />
                                                                                        <input type="image" src="images/btn_view.jpg" name="btn_submit" id="btn_submit" value="View"/>

                                                                                        <a href="javascript:;" onclick="document.location = 'list_advance.php';">
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
                                                        <td>
                                                            <div id="div_edit"></div>
                                                        </td>                                        
                                                    </tr>
                                                    <tr>
                                                        <td align="center" valign="top" style="padding-top:5px;">
                                                            <table align="center" width="100%" cellpadding="1" cellspacing="1" border="0" style="border:1px solid #CCCCCC;">
                                                                <?
                                                                if (isset($_POST["btn_submit_x"]) or isset($_GET['month'])) {
//                                                                    var_dump($_REQUEST);
                                                                    if (mysql_num_rows($result_prj) > 0) {
                                                                        $sno = $start + 1;
                                                                        ?>
                                                                        <tr>
                                                                            <td style="padding-top:10px" align="center">
                                                                                <form action="print_salary_slip.php" method="post" name="frm_chech_emp" id="frm_chech_emp" target="_blank">
                                                                                    <div id="div_attandance_list" style="overflow:scroll;height:500px;width:1000px">
                                                                                        <table align="center" width="100%" cellpadding="0" cellspacing="0" class="table1" border="1">
                                                                                            <tr class="gredBg">
                                                                                                <td width="5%" align="center">
                                                                                                    <b>
                                                                                                        Sno.
                                                                                                    </b>
                                                                                                </td>
                                                                                                <td width="5%" align="center">
                                                                                                    <b>
                                                                                                        Emp Id
                                                                                                    </b>
                                                                                                </td>
                                                                                                <td align="center">
                                                                                                    <b>
                                                                                                        Name
                                                                                                    </b>
                                                                                                </td>
                                                                                                <td align="center">
                                                                                                    <b>
                                                                                                        Fine
                                                                                                    </b>
                                                                                                </td>

                                                                                                <td align="center"><b>Dam Loss</b></td>
                                                                                                <td align="center"><b>Canteen/Mess</b></td>
                                                                                                <td align="center"><b>Society welfare</b></td>
                                                                                                <td align="center"><b>Electrical</b></td>
                                                                                                <td align="center"><b>Securtity</b></td>
                                                                                                <td align="center"><b>H/Rent</b></td>
                                                                                                <td align="center"><b>Deduction Date</b></td>
                                                                                                <td align="center"><b>Edit</b></td>
                                                                                                <td align="center"><b>Delete</b></td>
                                                                                            </tr>
                                                                                            <?
                                                                                            $sno = 1;
                                                                                            while ($row = mysql_fetch_array($result_prj)) {
                                                                                                ?>	
                                                                                                <tr>
                                                                                                    <td align="center"><?= $sno ?></td>
                                                                                                    <td align="center"><?= $row['ticket_no'] ?></td>
                                                                                                    <td align="left"><?= $row['first_name'] ?> <?= $row['last_name'] ?></td>
                                                                                                    <td align="center"><?= $row['salary_fine'] ?></td>
                                                                                                    <td align="center"><?= $row['salary_damage'] ?></td>
                                                                                                    <td align="center"><?= $row['salary_canteen'] ?></td>
                                                                                                    <td align="center"><?= $row['salary_society_welfare'] ?></td>
                                                                                                    <td align="center"><?= $row['salary_electrical'] ?></td>
                                                                                                    <td align="center"><?= $row['salarly_security'] ?></td>
                                                                                                    <td align="center"><?= $row['salary_house_rent'] ?></td>
                                                                                                    <td align="center"><?= getDatetime($row["salary_deduction_date"]); ?></td>
                                                                                                    <td align="center"><a href="javascript:;" onClick="get_frm('edit_salary_deduction.php', '<?= $row["salary_ded_id"] ?>', 'div_edit', '')">
                                                                                                            <img src="images/Modify.png" alt="Edit" title="Edit" border="0"></a></td>
                                                                                                    <td align="center"><a href="javascript:;" onClick="overlay(<?= $row["salary_ded_id"] ?>);">
                                                                                                            <img src="images/Delete.png" alt="Delete" title="Delete" border="0"></a>
                                                                                                    </td>  
                                                                                                </tr>
                                                                                                <?
                                                                                                $sno++;
                                                                                            }
                                                                                            ?>	
                                                                                            <tr>
                                                                                                <td align="center" colspan="12">
                                                                                                    <input type="hidden" name="card_month" id="card_month" value="<?= $month ?>"/>
                                                                                                    <input type="hidden" name="card_year" id="card_year" value="<?= $year ?>"/>
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
            <div id="overlay">
                <div class="form_msg">
                    <p>Are you sure to delete this Salary Deduction</p>
                    <form name="frm_del" action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
                        <input type="hidden" name="hidden_overlay" id="hidden_overlay" value="" />
                        <input type="submit" name="btn_del" value="Yes" />
                        <input type="button" onClick="overlay();" name="btn_close" value="No" />
                    </form>
                </div>
            </div>
            <iframe width=168 height=190 name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="calendar/ipopeng.htm" scrolling="no" frameborder="0" style="border:2px ridge; visibility:visible; z-index:999; position:absolute; left:-500px; top:0px;">
            </iframe>   
            <? include ("inc/hr_footer.php"); ?>	
