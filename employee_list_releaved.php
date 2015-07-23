<? include ("inc/dbconnection.php"); ?>

<?
$id = "";
$start = 0;
$id = $_GET["id"];
$check = $_GET["str"];
if ($check == "name") {
    $sql = "Select * From mpc_employee_master,mpc_account_detail
            Where mpc_employee_master.rec_id=mpc_account_detail.emp_id
            AND  mpc_account_detail.date_releaving !='0000-00-00'                 
            AND first_name like '$id%' order by first_name";

    /* $sql = "SELECT mpc_employee_master.*,mpc_department_employee.*,mpc_department_master.* FROM  " . $mysql_table_prefix . "employee_master ,mpc_department_employee,mpc_department_master "
      . "where mpc_employee_master.rec_id=mpc_department_employee.emp_id AND mpc_department_master.department_name like '$id%' order by department_name"; */
    $result = mysql_query($sql) or die("Error in : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());
}
if ($check == 'employee') {
    $sql = "SELECT mpc_employee_master.*,mpc_account_detail.emp_id,
                    mpc_department_master.*, mpc_account_detail.date_releaving 
                    FROM mpc_employee_master, mpc_account_detail,mpc_department_master
                    where mpc_employee_master.rec_id=mpc_account_detail.emp_id 
                    AND mpc_department_master.rec_id =mpc_employee_master.department 
                    AND mpc_account_detail.date_releaving !='0000-00-00' 
                    AND mpc_department_master.department_name like '%$id%' order by first_name";
    $result = mysql_query($sql) or die("Error in : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());
} if ($check == 'id') {
    $sql = "Select * From mpc_employee_master,mpc_account_detail
            Where mpc_employee_master.rec_id=mpc_account_detail.emp_id
            AND  mpc_account_detail.date_releaving !='0000-00-00'                 
            AND ticket_no like '%$id%' order by first_name";

    /* $sql = "SELECT mpc_employee_master.*,mpc_department_employee.*,mpc_department_employee.rec_id as department_id FROM  " . $mysql_table_prefix . "employee_master,mpc_department_employee where mpc_employee_master.rec_id=mpc_department_employee.emp_id and ticket_no like '$id%' order by first_name "; */
    $result = mysql_query($sql) or die("Error in : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());
}
?>
<table width = "100%" cellspacing = "2" cellpadding = "2" border = "0" align = "center" class = "border">
    <thead class = "blackHead" style = "text-align: center">
        <tr>
            <th>
                ID
            </th>
            <th>
                Name
            </th>
            <th>
                Department
            </th>
            <th>
                Action
            </th>
        </tr>
    </thead>
    <tbody bgcolor = "#F8F8F8" class = "tableTxt" style = "text-align: center">
        <?php
        while ($row_emp = mysql_fetch_array($result)) {
            ?>
            <tr>
                <td>
                    <?php echo $row_emp['ticket_no']; ?>
                </td>
                <td>
                    <?php echo $row_emp['first_name'] . "&nbsp;" . $row_emp['last_name']; ?>
                </td>
                <td>
                    <?php echo $row_emp['department_name']; ?>
                </td>
                <td>
                    <div id="<?php echo $count; ?>"  align="left" class="message_box" >

                        <div class="emp_snb expandable" style="width:280px;"> Edit</div>
                        <div class="categoryitems subLinks" style="height:auto;">
                            <div class="snb_sublink"><img src="images/red_bullet.png"/>
                                <a href="employee_detail.php?emp_id=<?= $row_emp['emp_id'] ?>">Employee Detail</a></div> 
                            <div class="snb_sublink"><img src="images/red_bullet.png"/><a href="javascript:;" onclick="get_frm('pf_detail.php', '<?= $row_emp['emp_id'] ?>', 'div_detail', '')">PF Detail</a></div>
                            <div class="snb_sublink"><img src="images/red_bullet.png"/><a  href="javascript:;" onclick="get_frm('account_detail.php', '<?= $row_emp['emp_id'] ?>', 'div_detail', '')">Account Detail</a></div>
                            <div class="snb_sublink"><img src="images/red_bullet.png"/><a href="javascript:;" onclick="get_frm('shift_detail.php', '<?= $row_emp['emp_id'] ?>', 'div_detail', '')">Shift Detail</a></div>
                            <div class="snb_sublink"><img src="images/red_bullet.png"/>
                                <a href="javascript:;" onclick="get_frm('dept_designation.php', '<?= $row_emp['emp_id'] ?>', 'div_detail', '')">Dept/designation Detail</a></div>
                            <div class="snb_sublink"><img src="images/red_bullet.png"/>
                                <a href="javascript:;" onclick="get_frm('salary_detail.php', '<?= $row_emp['emp_id'] ?>', 'div_detail', '')">Salary Detail</a></div>
                            <div class="snb_sublink"><img src="images/red_bullet.png"/><a href="javascript:;" onclick="get_frm('bank_detail.php', '<?= $row_emp['emp_id'] ?>', 'div_detail', '')">Bank Detail</a></div>
                            <!--<div class="snb_sublink"><img src="images/red_bullet.png"/><a href="javascript:;" onclick="get_frm('other_facility.php','<?= $row_emp['emp_id'] ?>','div_detail','')">Other Facility</a></div>-->
                            <div class="snb_sublink">
                                <img src="images/red_bullet.png"/>
                                <a href="javascript:;" onclick="overlay_unreleaved(<?= $row_emp['emp_id'] ?>)">Unrealeave Empoylee</a>
                            </div>
                            <div class="snb_sublink"><img src="images/red_bullet.png"/><a href="javascript:;" onclick="get_frm('releaving_detail.php', '<?= $row_emp['emp_id'] ?>', 'div_detail', '')">Releaving Detail</a></div>
                            <div class="snb_sublink"><img src="images/red_bullet.png"/><a href="javascript:;" onclick="overlay(<?= $row_emp['emp_id'] ?>)">Delete Employee</a></div>
                        </div>
                        <!--<div class="categoryitems subLinks" style="height:auto;">    
                            <div class="snb_sublink">
                                <img src="images/red_bullet.png"/>
                                <a href="employee_detail.php?emp_id=<?= $row_emp['emp_id'] ?>">Employee Detail</a>
                            </div>       
            
                            <div class="snb_sublink">
                                <img src="images/red_bullet.png"/>
                                <a href="javascript:;" onclick="get_frm('relealed_detail.php', '<?= $row_emp['emp_id'] ?>', 'div_detail', '')">Releaving Detail</a>
                            </div>
                            <div class="snb_sublink">
                                <img src="images/red_bullet.png"/>
                                <a href="javascript:;" onclick="overlay(<?= $row_emp['emp_id'] ?>)">Delete Employee</a>
                            </div>
                        </div> -->
                    </div>
                </td>
            </tr>
            <?php
            $count ++;
        }
        ?>
    </tbody>
</table>
<?php
/*
  if ($check == "name") {
  $sql = "SELECT * FROM  " . $mysql_table_prefix . "employee_master ,mpc_account_detail where mpc_employee_master.rec_id=mpc_account_detail.emp_id and mpc_account_detail.date_releaving !='0000-00-00' and first_name like '$id%' order by first_name";
  //$sql = $sql ." LIMIT " . $start . ", $row_limit";
  $result = mysql_query($sql) or die("Error in : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());
  } else {
  $sql = "SELECT * FROM  " . $mysql_table_prefix . "employee_master ,mpc_account_detail where mpc_employee_master.rec_id=mpc_account_detail.emp_id and mpc_account_detail.date_releaving !='0000-00-00' and ticket_no like '$id%' order by first_name";
  //	$sql = $sql ." LIMIT " . $start . ", $row_limit";
  $result = mysql_query($sql) or die("Error in : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());
  }
  if (mysql_num_rows($result) > 0) {
  while ($row = mysql_fetch_array($result)) {
  ?>
  <div class="emp_snb expandable"><?= $row['first_name'] ?>&nbsp;<?= $row['last_name'] ?></div>
  <div class="categoryitems subLinks" style="height:auto;">
  <div class="snb_sublink"><img src="images/red_bullet.png"/>
  <a href="employee_detail.php?emp_id=<?= $row['emp_id'] ?>">Employee Detail</a></div>
  <div class="snb_sublink"><img src="images/red_bullet.png"/><a href="javascript:;" onclick="get_frm('pf_detail.php', '<?= $row['emp_id'] ?>', 'div_detail', '')">PF Detail</a></div>
  <div class="snb_sublink"><img src="images/red_bullet.png"/><a  href="javascript:;" onclick="get_frm('account_detail.php', '<?= $row['emp_id'] ?>', 'div_detail', '')">Account Detail</a></div>
  <div class="snb_sublink"><img src="images/red_bullet.png"/><a href="javascript:;" onclick="get_frm('shift_detail.php', '<?= $row['emp_id'] ?>', 'div_detail', '')">Shift Detail</a></div>
  <div class="snb_sublink"><img src="images/red_bullet.png"/>
  <a href="javascript:;" onclick="get_frm('dept_designation.php', '<?= $row['emp_id'] ?>', 'div_detail', '')">Dept/designation Detail</a></div>
  <div class="snb_sublink"><img src="images/red_bullet.png"/>
  <a href="javascript:;" onclick="get_frm('salary_detail.php', '<?= $row['emp_id'] ?>', 'div_detail', '')">Salary Detail</a></div>
  <div class="snb_sublink"><img src="images/red_bullet.png"/><a href="javascript:;" onclick="get_frm('bank_detail.php', '<?= $row['emp_id'] ?>', 'div_detail', '')">Bank Detail</a></div>
  <!--<div class="snb_sublink"><img src="images/red_bullet.png"/><a href="javascript:;" onclick="get_frm('other_facility.php','<?= $row['emp_id'] ?>','div_detail','')">Other Facility</a></div>-->
  <div class="snb_sublink">
  <img src="images/red_bullet.png"/>
  <a href="javascript:;" onclick="overlay_unreleaved(<?= $row['emp_id'] ?>)">Unrealeave Empoylee</a>
  </div>
  <div class="snb_sublink"><img src="images/red_bullet.png"/><a href="javascript:;" onclick="get_frm('releaving_detail.php', '<?= $row['emp_id'] ?>', 'div_detail', '')">Releaving Detail</a></div>
  <div class="snb_sublink"><img src="images/red_bullet.png"/><a href="javascript:;" onclick="overlay(<?= $row['emp_id'] ?>)">Delete Employee</a></div>
  </div>
  <?
  }
  } */
?>