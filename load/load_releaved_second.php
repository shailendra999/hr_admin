<? include ("../inc/dbconnection.php");?>
<? include ("../inc/check_session.php");?>
<?php
$last_msg_id="";
if(isset($_GET['last_msg_id']))
{
	$last_msg_id=$_GET['last_msg_id'];
	$sql = "SELECT * FROM mpc_employee_master ,mpc_account_detail where mpc_employee_master.rec_id=mpc_account_detail.emp_id and mpc_account_detail.date_releaving !='0000-00-00' ORDER BY first_name LIMIT $last_msg_id, 20";
 	$result=mysql_query($sql);
	$count = $last_msg_id+1;
	while($row_emp=mysql_fetch_array($result))
	{
	?>
		<div id="<?php echo $count; ?>"  align="left" class="message_box" >
            <div class="emp_snb expandable" style="width:280px;" headerindex="<?=$count-1?>h"><span class="accordprefix"></span><?=$row_emp['first_name']?><span class="accordsuffix"></span></div>
            <div class="categoryitems subLinks" style="height: auto; display: none;" contentindex="<?=$count-1?>c">    
                <div class="snb_sublink">
                    <img src="images/red_bullet.png"/>
                    <a href="employee_detail.php?emp_id=<?=$row_emp['rec_id']?>">Employee Detail</a>
                </div>       
                <div class="snb_sublink">
                    <img src="images/red_bullet.png"/>
                    <a href="javascript:;" onclick="get_frm('pf_detail.php','<?=$row_emp['rec_id']?>','div_detail','')">PF Detail</a>
                </div>
                <div class="snb_sublink">
                    <img src="images/red_bullet.png"/>
                    <a  href="javascript:;" onclick="get_frm('account_detail.php','<?=$row_emp['rec_id']?>','div_detail','')">Account Detail</a>
                </div>
                <div class="snb_sublink">
                    <img src="images/red_bullet.png"/>
                    <a href="javascript:;" onclick="get_frm('shift_detail.php','<?=$row_emp['rec_id']?>','div_detail','')">Shift Detail</a>
                </div>
                <div class="snb_sublink">
                    <img src="images/red_bullet.png"/>
                    <a href="javascript:;" onclick="get_frm('dept_designation.php','<?=$row_emp['rec_id']?>','div_detail','')">Dept/designation Detail</a>
                 </div>
                 <div class="snb_sublink">
                     <img src="images/red_bullet.png"/>
                     <a href="javascript:;" onclick="get_frm('salary_detail.php','<?=$row_emp['rec_id']?>','div_detail','')">Salary Detail</a>
                 </div>
                <div class="snb_sublink">
                    <img src="images/red_bullet.png"/>
                    <a href="javascript:;" onclick="get_frm('bank_detail.php','<?=$row_emp['rec_id']?>','div_detail','')">Bank Detail</a>
                </div>
                <div class="snb_sublink">
                    <img src="images/red_bullet.png"/>
                    <a href="javascript:;" onclick="get_frm('other_facility.php','<?=$row_emp['rec_id']?>','div_detail','')">Other Facility</a>
                </div>
                <div class="snb_sublink">
                    <img src="images/red_bullet.png"/>
                    <a href="javascript:;" onclick="get_frm('releaving_detail.php','<?=$row_emp['rec_id']?>','div_detail','')">Releaving Detail</a>
                </div>
                <div class="snb_sublink">
                    <img src="images/red_bullet.png"/>
                    <a href="javascript:;" onclick="overlay(<?=$row_emp['rec_id']?>)">Delete Empoylee</a>
                </div>
            </div>
        </div>
<?php
	$count++;
	}
	
}
?>
