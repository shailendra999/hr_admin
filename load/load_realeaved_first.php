<?php
$sql = mysql_query("SELECT mpc_employee_master.*,mpc_account_detail.emp_id,
                    mpc_department_master.*, mpc_account_detail.date_releaving 
                    FROM mpc_employee_master, mpc_account_detail,mpc_department_master
                    where mpc_employee_master.rec_id=mpc_account_detail.emp_id 
                    AND mpc_department_master.rec_id =mpc_employee_master.department 
                    AND mpc_account_detail.date_releaving !='0000-00-00' $filter_sql 
                    ORDER BY first_name");
$count = 1;
?>
<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center" class="border">
    <thead class="blackHead" style="text-align: center">
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