<?php
session_start();
$session_palnt_id = $_SESSION['session_user_plant'];
include ("inc/dbconnection.php");
$id = "";
$start = 0;
$id = $_GET["id"];
$check = $_GET["str"];
if ($check == "employee") {
	 if ($id != null) {
		$sql = "SELECT mpc_employee_master.*,
      mpc_department_master.*
      FROM mpc_employee_master,mpc_department_master
      where mpc_department_master.rec_id =mpc_employee_master.department
      AND mpc_department_master.department_name like '%$id%'
      ORDER BY mpc_department_master.department_name;";
    } else {
        $sql = "Select mpc_employee_master.*, mpc_department_master.*
            from mpc_department_master 
            RIGHT JOIN mpc_employee_master 
            ON mpc_department_master.rec_id = mpc_employee_master.department
            AND mpc_department_master.department_name like '%$id%' 
            ORDER BY mpc_employee_master.department";
    }
    $result = mysql_query($sql) or die("Error in : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());
}

if ($check == "name") {
    if ($id != null) {
        $sql = "SELECT mpc_employee_master.*,
                mpc_department_master.*
                FROM mpc_employee_master,mpc_department_master
                where mpc_department_master.rec_id =mpc_employee_master.department 
                AND mpc_employee_master.first_name like '%$id%' 
                ORDER BY first_name";
    } else {

        $sql = "Select mpc_employee_master.*,
             mpc_department_master.* 
             from mpc_department_master 
             RIGHT JOIN mpc_employee_master 
             ON mpc_department_master.rec_id = mpc_employee_master.department 
             AND mpc_employee_master.first_name like '%$id%'
            ORDER BY mpc_employee_master.first_name";
    }
    $result = mysql_query($sql) or die("Error in : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());
} elseif ($check == "id") {
    if ($id != null) {
        $que = mysql_query("SELECT department FROM  mpc_employee_master WHERE ticket_no='$id'");
        $row = mysql_fetch_array($que);
        $dep = $row['department'];
        if ($dep != 0) {
            $sql = "SELECT * FROM mpc_employee_master, mpc_department_master
                   where mpc_department_master.rec_id = mpc_employee_master.department
                   AND mpc_employee_master.ticket_no like '$id%' order by ticket_no ";
            $result = mysql_query($sql) or die("Error in : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());
        }
        if ($dep == 0) {
            $sql = "select * from mpc_employee_master where ticket_no='$id'
                   AND mpc_employee_master.ticket_no like '$id%' order by ticket_no";
            $result = mysql_query($sql) or die("Error in : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());
        }
    } else {
        $sql = ("SELECT mpc_employee_master.*,mpc_department_master.* FROM mpc_department_master
                RIGHT JOIN mpc_employee_master ON mpc_department_master.rec_id = mpc_employee_master.department
                AND mpc_employee_master.ticket_no like '%$id%'
                ORDER BY mpc_employee_master.ticket_no");

        $result = mysql_query($sql) or die("Error in : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());
    }
}
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
        if (mysql_num_rows($result) > 0) {
            while ($row = mysql_fetch_array($result)) {
                ?>
                <tr>
                    <td><?php echo $row['ticket_no']; ?></td>
                    <td><?php echo $row['first_name'] . "&nbsp;" . $row['last_name']; ?></td>
                    <td><?php echo $row['department_name']; ?></td>
                    <td><div class="emp_snb expandable">Edit</div>
                        <div class="categoryitems subLinks" style="height:auto;">
                            <div class="snb_sublink"><img src="images/red_bullet.png"/>
                                <!--a href="employee_detail.php?emp_id=<?= $row['emp_id'] ?>">Employee Detail</a-->
                                <a href="javascript:;" onclick="get_frm('edit_request.php', '<?= $row['emp_id'] ?>', 'div_detail', '')">Edit Details</a>
                            </div> 
                            <div class="snb_sublink"><img src="images/red_bullet.png"/>
                                <a href="javascript:;" onclick="get_frm('releaving_detail.php', '<?= $row['emp_id'] ?>', 'div_detail', '')">Relieving Detail</a>
                            </div>
                            <div class="snb_sublink"><img src="images/red_bullet.png"/><a href="javascript:;" onclick="overlay(<?= $row['emp_id'] ?>)">Delete Employee</a></div>
                        </div>
                    </td>
                </tr>
                <?php
            }
            ?>
        </tbody>
        <?php
    } else {
        ?>
        <tbody>
            <tr>
                <td colspan="5">
                    There is no record found!
                </td>
            </tr>
        </tbody>
        <?php
    }
    ?>
</table>

