<?php
include("inc/dbconnection.php");
echo $dep_ref = $_REQUEST['dll_dep'];
echo $check = $_REQUEST['check'];
echo $txt = $_REQUEST['txt'];

?>
<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center"class="border">
    <tr bgcolor="#f3fbd2" class="tableTxt"><th align="center">Name</th>
        <th align="center">Attendance_Status</th>
        <th align="center">Avail Date</th>
        <th align="center">Holiday Date</th>
        <th align="center">Reason</th>
        <th align="center">EDIT REASON</th>
    </tr>
    <?php
    /*if ($check == 'name')
	 {*/
		 if($dep_ref =="0" ||empty($dep_ref) || $dep_ref=="" )
		 {
			 echo "select mpc_attendence_master.*,mpc_employee_master.first_name,mpc_employee_master.last_name from mpc_attendence_master,mpc_employee_master where mpc_attendence_master.attendance_status='C/OFF' and mpc_employee_master.emp_id=mpc_attendence_master.emp_id and mpc_employee_master.$check LIKE '%$txt%'";
			 
			  $que = mysql_query("select mpc_attendence_master.*,mpc_employee_master.first_name,mpc_employee_master.last_name from mpc_attendence_master,mpc_employee_master where mpc_attendence_master.attendance_status='C/OFF' and mpc_employee_master.emp_id=mpc_attendence_master.emp_id and mpc_employee_master.$check LIKE '%$txt%'"); 
		}
		else
		{ 
		
         $que = mysql_query("select mpc_attendence_master.*,mpc_employee_master.first_name,mpc_employee_master.last_name,mpc_employee_master.department from mpc_attendence_master,mpc_employee_master where mpc_attendence_master.attendance_status='C/OFF' and mpc_employee_master.emp_id=mpc_attendence_master.emp_id and mpc_employee_master.department='$dep_ref' and mpc_employee_master.$check LIKE '%$txt%'");
		}

   
    while ($row = mysql_fetch_array($que) ) {

        ?>
        <tr class="tableTxt" bgcolor="#F8F8F8"><td>
                <?php echo $row['first_name'] ?>&nbsp;<?php echo $row['last_name'] ?>
            </td><td align="center"><?php echo $row['attendance_status'] ?></td>
            <td align="center"><?php echo $row['date'] ?></td>
            <td align="center"><?php echo $row['avail_date'] ?></td>
            <td align="center"><?php echo $row['reason'] ?></td>
            <td align="center"><a href="update_cof.php?emp_id=<?php echo $row['emp_id'] ?>&name=<?php echo $row['first_name'] ?><?php echo $row['last_name'] ?>&attendance_status=<?php echo $row['attendance_status'] ?>&date=<?php echo $row['date'] ?>"><img border="0" title="Edit" alt="Edit" src="images/Modify.png"></a></td>
            <td align="center">PAID</td>
        </tr>
    <?php }
    ?>
</table>
<div id="flip">BALANCE C/OFF CLICK HERE</div>
