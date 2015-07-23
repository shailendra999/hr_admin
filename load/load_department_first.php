<?php
 $sql = "Select * From mpc_employee_master,mpc_department_employee,mpc_department_master
                 Where mpc_employee_master.rec_id = mpc_department_employee.emp_id AND mpc_department_master.rec_id = mpc_department_employee.dept_id
                 AND mpc_department_master.department_name LIKE '$id%' ";
   
    $result = mysql_query($sql) or die("Error in : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());
$count = 1;
?>
<table width="100%" align="center" cellpadding="2" cellspacing="2" border="0" class="border">
            <tr class="blackHead">
                <td align="center">Employee Id</td>
                <td align="center">Employee Name</td>
                <td align="center">Department</td>
                <td align="center">From</td>
                <td align="center">To</td>
                <td align="center">Edit</td>
                <td align="center">Delete</td>
            </tr>
            <?
            while ($row = mysql_fetch_array($result)) {
                ?>
                <tr <? if ($sno % 2 == 1) { ?> bgcolor="#F8F8F8" <? } ?> class="tableTxt">
                    <td align="center">
                        <?= $row["ticket_no"] ?>
                    </td>
                    <td align="center">
                        <?= $row["first_name"] ?> <?= $row["last_name"] ?> 
                    </td>
                    <td align="center">
                        <?php echo $row['department_name'] ?>
                        <? //= getdeptDetail('department_name', 'rec_id', $row["dept_id"]) ?>
                    </td>
                    <td align="center">
                        <?= getDatetime($row["from_date"]) ?>
                    </td>
                    <td align="center">
                        <?
                        if ($row["to_date"] == '0000-00-00') {
                            echo 'TODAY';
                        } else {
                            echo getDatetime($row["to_date"]);
                        }
                        ?>
                    </td>
                    <td align="center"><a href="javascript:;" onClick="get_frm('edit_department_list.php', '<?= $row["ticket_no"] ?>', 'div_edit', '')"><img src="images/Modify.png" alt="Edit" title="Edit" border="0"></a>
                    </td>
                    <td align="center"><a href="javascript:;" onClick="overlay(<?= $row["department_id"] ?>);">
                            <img src="images/Delete.png" alt="Delete" title="Delete" border="0"></a>
                    </td>  
                </tr>
                <?
            }
            $emp_id = $row["emp_id"];
            $count++;
            ?>   
        </table>