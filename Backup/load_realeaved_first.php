<?php
$sql=mysql_query("SELECT * FROM mpc_employee_master,mpc_account_detail where mpc_employee_master.rec_id=mpc_account_detail.emp_id and mpc_account_detail.date_releaving !='0000-00-00' ORDER BY first_name LIMIT 0,20");
$count = 1;
while($row_emp=mysql_fetch_array($sql))
{
?>
<div id="<?php echo $count; ?>"  align="left" class="message_box" >

    <div class="emp_snb expandable" style="width:280px;"><?=$row_emp['first_name']?></div>
    <div class="categoryitems subLinks" style="height:auto;">    
        <div class="snb_sublink">
            <img src="images/red_bullet.png"/>
            <a href="employee_detail.php?emp_id=<?=$row_emp['emp_id']?>">Employee Detail</a>
        </div>       
        <div class="snb_sublink">
            <img src="images/red_bullet.png"/>
            <a href="javascript:;" onclick="get_frm('pf_detail.php','<?=$row_emp['emp_id']?>','div_detail','')">PF Detail</a>
        </div>
        <div class="snb_sublink">
            <img src="images/red_bullet.png"/>
            <a  href="javascript:;" onclick="get_frm('account_detail.php','<?=$row_emp['emp_id']?>','div_detail','')">Account Detail</a>
        </div>
        <div class="snb_sublink">
            <img src="images/red_bullet.png"/>
            <a href="javascript:;" onclick="get_frm('shift_detail.php','<?=$row_emp['emp_id']?>','div_detail','')">Shift Detail</a>
        </div>
        <div class="snb_sublink">
            <img src="images/red_bullet.png"/>
            <a href="javascript:;" onclick="get_frm('dept_designation.php','<?=$row_emp['emp_id']?>','div_detail','')">Dept/designation Detail</a>
         </div>
         <div class="snb_sublink">
             <img src="images/red_bullet.png"/>
             <a href="javascript:;" onclick="get_frm('salary_detail.php','<?=$row_emp['emp_id']?>','div_detail','')">Salary Detail</a>
         </div>
        <div class="snb_sublink">
            <img src="images/red_bullet.png"/>
            <a href="javascript:;" onclick="get_frm('bank_detail.php','<?=$row_emp['emp_id']?>','div_detail','')">Bank Detail</a>
        </div>
       <!-- <div class="snb_sublink">
            <img src="images/red_bullet.png"/>
            <a href="javascript:;" onclick="get_frm('other_facility.php','<?=$row_emp['emp_id']?>','div_detail','')">Other Facility</a>
        </div>-->
        <div class="snb_sublink">
            <img src="images/red_bullet.png"/>
            <a href="javascript:;" onclick="get_frm('relealed_detail.php','<?=$row_emp['emp_id']?>','div_detail','')">Releaving Detail</a>
        </div>
        <div class="snb_sublink">
            <img src="images/red_bullet.png"/>
            <a href="javascript:;" onclick="overlay_unreleaved(<?=$row_emp['emp_id']?>)">Unrealeave Empoylee</a>
        </div>
        <div class="snb_sublink">
            <img src="images/red_bullet.png"/>
            <a href="javascript:;" onclick="overlay(<?=$row_emp['emp_id']?>)">Delete Empoylee</a>
        </div>
    </div>
</div>

<?php
	 $count ++;
}
?>
