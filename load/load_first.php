<?php
$filter_sql = "";
if (isset($_GET['ticket_no'])) {
    $ticket_no = $_GET['ticket_no'];
    $filter_sql = "and ticket_no ='$ticket_no'";
}
/*
  $sql = mysql_query("SELECT mpc_employee_master.*,mpc_account_detail.emp_id,
  mpc_department_master.*, mpc_account_detail.date_releaving
  FROM mpc_employee_master, mpc_account_detail,mpc_department_master
  where mpc_employee_master.rec_id=mpc_account_detail.emp_id
  AND mpc_department_master.rec_id =mpc_employee_master.department

  AND mpc_account_detail.date_releaving ='0000-00-00' $filter_sql
  ORDER BY first_name");
  $query = "Select * from mpc_employee_master,mpc_account_detail "
  . "where mpc_employee_master.rec_id=mpc_account_detail.emp_id"
  . "AND mpc_account_detail.date_releaving ='0000-00-00'";
  $sql = mysql_query($query);
 */

//$sql = mysql_query("SELECT mpc_employee_master.*,mpc_account_detail.emp_id,
//  mpc_department_master.*, mpc_account_detail.date_releaving
//  FROM mpc_employee_master, mpc_account_detail,mpc_department_master
//  where mpc_employee_master.emp_id=mpc_account_detail.emp_id
//  AND mpc_department_master.rec_id =mpc_employee_master.department
//  AND mpc_account_detail.date_releaving ='0000-00-00' $filter_sql
//  ORDER BY first_name");


$sql = mysql_query("Select mpc_employee_master.*, mpc_department_master.* 
      from mpc_department_master 
      RIGHT JOIN mpc_employee_master 
      ON mpc_department_master.rec_id = mpc_employee_master.department 
      $filter_sql ORDER BY mpc_employee_master.rec_id");

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
    <tbody bgcolor="#F8F8F8" class="tableTxt" style="text-align: center">
        <?php
        while ($row_emp = mysql_fetch_array($sql)) {
            ?>
            <tr>
                <td>
                    <?php echo $row_emp['ticket_no']; ?>
                </td>
                <td>
                    <?php echo $row_emp['first_name'] . "&nbsp;" . $row_emp['last_name']; ?>
                </td>
                <td>
                    <?php
                    $q = mysql_query("Select * from mpc_department_master where rec_id = $row_emp[department]");
                    $row = mysql_fetch_array($q);
                    echo $row['department_name'];
                    ?>
                </td>
                <td>
                    <div class="emp_snb expandable">
                        Edit
                    </div>
                    <div class="categoryitems subLinks" style="height:auto;">
                        <div class="snb_sublink"><img src="images/red_bullet.png"/>
                            <a href="javascript:;" onclick="get_frm('edit_request.php', '<?= $row_emp['emp_id'] ?>', 'div_detail', '')">Edit Details</a>
                        </div>
                        <div class="snb_sublink"><img src="images/red_bullet.png"/><a href="javascript:;" onclick="get_frm('releaving_detail.php', '<?= $row_emp['emp_id'] ?>', 'div_detail', '')">Relieving Detail</a></div>
                        <!--<div class="snb_sublink"><img src="images/red_bullet.png"/><a href="javascript:;" onclick="overlay(<?= $row_emp['emp_id'] ?>)">Delete Employee</a></div>-->
                    </div>
                </td>
            </tr>
            <?php
            $count ++;
        }
        ?>
    </tbody>
</table>