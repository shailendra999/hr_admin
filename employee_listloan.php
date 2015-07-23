<? include ("inc/dbconnection.php"); ?>

<?
$id = "";
$start = 0;
$id = $_GET["id"];
$check = $_GET["str"];
if ($check == "name") {

    /* echo $sql = "SELECT mpc_employee_master.*,mpc_account_detail.emp_id,mpc_account_detail.date_releaving FROM  ".$mysql_table_prefix."employee_master ,mpc_account_detail where mpc_employee_master.first_name!='null' and mpc_account_detail.date_releaving ='0000-00-00' and first_name like '$id' order by first_name";
      die(); */

    $sql = "SELECT mpc_employee_master.*,mpc_account_detail.emp_id,mpc_account_detail.date_releaving FROM  " . $mysql_table_prefix . "employee_master ,mpc_account_detail where mpc_employee_master.rec_id=mpc_account_detail.emp_id and mpc_account_detail.date_releaving ='0000-00-00' and first_name like '$id%' AND first_name!= '' order by first_name";

//$sql = $sql ." LIMIT " . $start . ", $row_limit";
    $result = mysql_query($sql) or die("Error in : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());
} elseif ($check == "id") {
    /* $sql = "SELECT mpc_employee_master.*,mpc_account_detail.emp_id,mpc_account_detail.date_releaving FROM  ".$mysql_table_prefix."employee_master,mpc_account_detail where mpc_employee_master.rec_id!='null' and mpc_account_detail.date_releaving ='0000-00-00' and  ticket_no like '$id' order by first_name ";  
     */
    $sql = "SELECT mpc_employee_master.*,mpc_account_detail.emp_id,mpc_account_detail.date_releaving FROM  " . $mysql_table_prefix . "employee_master,mpc_account_detail where mpc_employee_master.rec_id=mpc_account_detail.emp_id and mpc_account_detail.date_releaving ='0000-00-00' and  ticket_no like '$id%' AND first_name!= '' order by first_name ";

    //$sql = $sql ." LIMIT " . $start . ", $row_limit";
    $result = mysql_query($sql) or die("Error in : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());
} elseif ($check == "employee") {
    $sql = "SELECT mpc_department_master.department_name,mpc_employee_master.*,mpc_account_detail.emp_id,mpc_account_detail.date_releaving FROM  " . $mysql_table_prefix . "employee_master,mpc_department_master,mpc_account_detail where mpc_employee_master.rec_id=mpc_account_detail.emp_id and mpc_account_detail.date_releaving ='0000-00-00' and  mpc_department_master.department_name like '$id%' AND mpc_department_master.rec_id = mpc_employee_master.department order by first_name ";
    $result = mysql_query($sql) or die("Error in : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());
}


if (mysql_num_rows($result) > 0) {
    while ($row = mysql_fetch_array($result)) {
        ?>

        <div class="emp_snb expandable"><?php echo $row['first_name']; ?>&nbsp;<?php echo $row['last_name']; ?></div>
        <!-- My code is start from here. plz check it-->

        </div>
        <div class="categoryitems subLinks" style="height:auto;
             ">
            <div class="snb_sublink"><img src="images/red_bullet.png"/><a  href="javascript:;
                                                                           " onclick="get_frm('account_detail.php', '<?= $row['rec_id'] ?>', 'div_detail', '')">Account Detail</a></div>
                                                                                     <!--<div class="snb_sublink"><img src="images/red_bullet.png"/>
                                                                                                     <a href="employee_detail.php?emp_id = <//?=$row['rec_id']
                                                                           ?>">Employee Detail</a></div> -->
            <div class="snb_sublink"><img src="images/red_bullet.png"/><a href="javascript:;" onclick="get_frm('releaving_detail.php', '<?= $row['rec_id'] ?>', 'div_detail', '')">Releaving Detail</a></div>
            <div class="snb_sublink"><img src="images/red_bullet.png"/><a href="javascript:;" onclick="overlay(<?= $row['rec_id'] ?>)">Delete Employee</a></div>
        </div>

        <!--My code  Ende here and plz review it-->

                                                                                    <!--  <div class="snb_sublink"><img src="images/red_bullet.png"/><a href="javascript:;" onclick="get_frm('shift_detail.php','<//?=$row['rec_id']?>','div_detail','')">Shift Detail</a></div>
                                                                                    <div class="snb_sublink"><img src="images/red_bullet.png"/>
                                                                                    <a href="javascript:;" onclick="get_frm('dept_designation.php','<//?=$row['rec_id']?>','div_detail','')">Dept/designation Detail</a></div>
                                                                                    <div class="snb_sublink"><img src="images/red_bullet.png"/>
                                                                                       <a href="javascript:;" onclick="get_frm('salary_detail.php','<//?=$row['rec_id']?>','div_detail','')">Salary Detail</a></div>
                                                                                    <div class="snb_sublink"><img src="images/red_bullet.png"/><a href="javascript:;" onclick="get_frm('bank_detail.php','<//?=$row['rec_id']?>','div_detail','')">Bank Detail</a></div>
                                                                                    <div class="snb_sublink"><img src="images/red_bullet.png"/><a href="javascript:;" onclick="get_frm('other_facility.php','<//?=$row['rec_id']?>','div_detail','')">Other Facility</a></div>
                                                                                    <div class="snb_sublink"><img src="images/red_bullet.png"/><a href="javascript:;" onclick="get_frm('releaving_detail.php','<//?=$row['rec_id']?>','div_detail','')">Releaving Detail</a></div>
                                                                                    <div class="snb_sublink"><img src="images/red_bullet.png"/><a href="javascript:;" onclick="overlay(<? //=$row['rec_id']          ?>)">Delete Employee</a></div>
                                                                                    </div>-->
        <?
    }
}
?>